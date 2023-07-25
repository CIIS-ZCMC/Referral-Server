<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\ReferralStatus;

class ReferralStatusController extends Controller
{
    public function showAllReferralStatus(Request $request)
    {
        try{
            $referralStatus = ReferralStatus::all();

            return response()->json(['data'=>$referralStatus],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Status Controller[showAllReferralStatus] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $name = strip_tags($value); 

            $referralStatus = new ReferralStatus;
            $referralStatus -> name = $name;
            $referralStatus -> created_at = now();
            $referralStatus -> updated_at = now();
            $referralStatus -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Status Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function showReferralStatus($id, Request $request)
    {
        try{
            $referralStatus = ReferralStatus::find($id);
            
            if(!$referralStatus)
            {
                return response()->json(['message'=>'No record found.'],404);
            }

            return response()->json(['data'=>$referralStatus],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Status Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $referralStatus = ReferralStatus::find($id);
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $name = strip_tags($value); 

            $referralStatus -> name = $name;
            $referralStatus -> updated_at = now();
            $referralStatus -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Status Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function destroy($id, Request $request)
    {
        try{
            $referralStatus = ReferralStatus::find($id);
            
            if(!$referralStatus)
            {
                return response()->json(['message'=>'No record found.'],404);
            }

            $referralStatus -> deleted = TRUE;
            $referralStatus -> updated_at = now();
            $referralStatus -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Referral Status Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
