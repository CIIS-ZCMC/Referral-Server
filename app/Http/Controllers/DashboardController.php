<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Profile;
use App\Models\Transfer;

class DashboardController extends Controller
{
    public function cardRequest(Request $request)
    {
        try{
            $hospital = Profile::where('FK_user_ID', $request['id'])->value('FK_hospital_ID');

            $transfer = Transfer::where('FK_referred_from_ID', $hospital)->count();

            $referredPatients = DB::raw('((SELECT COUNT(id) FROM referral) as cancelledReferral WHERE referrals_status = 4');
            $incomingPatients = DB::raw('(SELECT COUNT(id) FROM referral) as cancelledReferral WHERE referrals_status = 2');
            $cancelledReferrals = DB::raw('(SELECT COUNT(id) FROM referral) as cancelledReferral WHERE referrals_status = 7');
            $transferedReferral = DB::raw('(SELECT COUNT(FK_referral_ID) FROM referral_transfer) as transferedReferral');
            
            $cardRequest = DB::table('patients') 
                ->select($referredPatients, $incomingPatients, $cancelledReferrals, $transferedReferral)
                ->first();

            return response()->json(['data' => $cardRequest], 200);
        }catch(\Throwable $th){
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function topReferringFacility(Request $request)
    {
        try{
            $topreferringfacility = DB::table('hospital as h')
                ->select('h.name as hospital', 'a.province', DB::raw('COUNT(ref.FK_hospital_ID) as totalReferrals'))
                ->join('referrals as ref', 'ref.FK_hospital_ID', 'h.id')
                ->join('address as a', 'a.id', 'h.FK_address_ID')
                ->groupBy('h.name', 'a.province', 'h.id')
                ->orderByDesc('totalReferrals')
                ->limit(5)
                ->get();

            return response()->json(['data'=>$topreferringfacility],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[topReferringFacility] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function latestReferrals(Request $request)
    {
        try{
            $latestreferrals = DB::table('referrals as ref')
                ->select('ref.id', 
                    'h.name as health_facility', 
                    'ref.request_date as referral_date', 
                    'adm.type as referral_type',
                    DB::RAW("CONCAT(p.first_name,' ',p.last_name) as patient_name"), 
                    DB::RAW('CASE WHEN ref.status = 0 THEN "PENDING" 
                        WHEN ref.status = 1 THEN "Reviewed/Viewed"
                        WHEN ref.status = 2 THEN "Accepted
                        WHEN ref.status = 3 THEN "Arrived"
                        WHEN ref.status = 4 THEN "Admitted"
                        WHEN ref.status = 5 THEN "Discharged"
                        ELSE "Transferred" END as status'))
                ->join('admitting as adm','adm.id','ref.FK_admitting_details_ID')
                ->join('hospital as h','h.id','ref.FK_hospital_ID')
                ->join('patient as p','p.id','ref.FK_patient_ID')
                ->orderBy('ref.request_date')
                ->get();

            return response()->json(['data'=>$latestreferrals],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[topReferringFacility] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
