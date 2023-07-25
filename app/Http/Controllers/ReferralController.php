<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Referrals;
use App\Models\ReferralStatus;
use App\Models\CanceledReferral;
use App\Models\Logs;

class ReferralController extends Controller
{
    public function incomingReferral(Request $request)
    {
        try{
            $referral = DB::table('referrals as ref')
                -> select('ref.id',DB::raw('CONCAT(first_name," ",last_name) as name'), 'h.name as hospital', 'ref.date')
                -> join('patients as p','p.id','ref.FK_patient_ID')
                -> join('hospital as h', 'h.id', 'ref.FK_hospital_ID')
                -> where('ref.pending', 0)
                -> get();

            return response()->json(['data'=>$referral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[incomingReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function showAllReferral(Request $request)
    {
        try{
            $referral = Referrals::all();

            return response()->json(['data'=>$referral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[showAllReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function showAllCanceledReferral(Request $request)
    {
        try{
            $canceledReferral = DB::table('cancelled_referral as cRef')
                -> select('ref.id' , 'h.name as hospital', 'ref.date',
                    DB::raw('CONCAT(first_name," ",last_name) as name'), 
                    DB::raw('TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE()) as age'))
                -> join('referrals as ref', 'ref.id', 'cRef.FK_referral_ID')
                -> join('patients as p', 'p.id', 'ref.FK_patient_ID')
                -> join('hospital as h', 'h.id', 'ref.FK_hospital_ID')
                -> get();
            
            return response()->json(['data'=>$canceledReferral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[showAllCanceledReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    

    public function restoreReferral($id, Request $request)
    {
        try{
            $referral = Referral::find($id);
            $cancelledReferral = CanceledReferral::where('FK_referral_ID', $id) -> first();

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }

            $referral -> referral_status = $canceledReferral['prevStatus'];
            $referral -> updated_at = now();
            $referral -> save();

            $canceledReferral -> FK_referral_ID = null;
            $canceledReferral -> delete();

            return response()->json(['data'=>$canceledReferral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[restoreReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|max:255',
                'request_edit' => 'required|string|max:255',
                'request_date' => 'required|string|max:255',
                'updated_at' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'status' => $request->input('status'),
                'request_edit' => $request->input('request_edit'),
                'request_date' => $request->input('request_date'),
                'updated_at' => $request->input('updated_at'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $referral = new Referral;
            $referral -> status = $cleanData['status'];
            $referral -> request_edit = $cleanData['request_edit'];
            $referral -> request_date = $cleanData['request_date'];
            $referral -> updated_at = $cleanData['updated_at'];
            $referral -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function acceptReferral($id, Request $request)
    {
        try{
            $accept = 1;
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }
            
            $validator = Validator::make($request->all(), [
                'reason' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $referral -> referral_status = $accept;
            $referral -> updated_at = now();
            $referral -> save();
            
            $logs = new Logs;
            $logs -> FK_referral_ID = $referral['id'];
            $logs -> FK_referral_status_ID = $accept;
            $logs -> description = strip_tags($request -> input('reason'));
            $logs -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[acceptReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    
    public function viewReferral($id, Request $request)
    {
        try{
            $view = 1;
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }

            $referral -> referral_status = $view;
            $referral -> updated_at = now();
            $referral -> save();
            
            $logs = new Logs;
            $logs -> FK_referral_ID = $referral['id'];
            $logs -> FK_referral_status_ID = $view;
            $logs -> save();
            
            $watcher = Watcher::where('id', $referral['FK_watcher_ID']) -> first();
            $admitting = Admitting::select('*') 
                -> join('specializations', 'specializations.id', 'admitting.FK_specializaitons_ID') 
                -> where('id', $referral['FK_admitting_ID']) 
                -> first();

            $response = [
                'referral'  => $referral->toArray(),
                'watcher'   => $watcher->toArray(),
                'admitting' => $admitting->toArray(),
            ];

            return response()->json(['data'=>$response],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[viewReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    
    public function showReferral($id, Request $request)
    {
        try{
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }

            return response()->json(['data'=>$referral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[showReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'required|string|max:255',
                'request_edit' => 'required|string|max:255',
                'request_date' => 'required|string|max:255',
                'updated_at' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'status' => $request->input('status'),
                'request_edit' => $request->input('request_edit'),
                'request_date' => $request->input('request_date'),
                'updated_at' => $request->input('updated_at'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $referral -> status = $cleanData['status'];
            $referral -> request_edit = $cleanData['request_edit'];
            $referral -> request_date = $cleanData['request_date'];
            $referral -> updated_at = $cleanData['updated_at'];
            $referral -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function canceledReferral($id, Request $request)
    {
        try{
            $cancel = 7;
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }
            
            $validator = Validator::make($request->all(), [
                'remarks' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $referral -> referral_status = $cancel;
            $referral -> updated_at = now();
            $referral -> save();
            
            $remarks = strip_tags($request -> input('remarks')); 

            $cancelReferral = new CanceledReferral;
            $cancelReferral -> remarks = $remarks;
            $cancelReferral -> FK_referral_ID = $referral['id'];
            $cancelReferral -> date = now();
            $cancelReferral -> prevStatus = $referral['referral_status'];
            $cancelReferral -> save();
            
            $logs = new Logs;
            $logs -> FK_referral_ID = $referral['id'];
            $logs -> FK_referral_status_ID = $cancel;
            $logs -> description = strip_tags($request -> input('reason'));
            $logs -> save();

            return response()->json(['data'=> 'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[canceledReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $referral = Referrals::find($id);

            if(!$referral)
            {
                return response()->json(['message'=>'No referral found.'],404);
            }
            $referral -> deleted = TRUE;
            $referral -> updated_at = now();
            $referral -> save();

            return response()->json(['data'=>$referral],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
