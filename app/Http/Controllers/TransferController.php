<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Transfer;

class TransferController extends Controller
{
    public function showAllTransfer(Request $request)
    {
        try{
            $transfer = DB::table('transfer as t')
                -> select('ref.id', 't.date', 't.reaspon','rf.name as status','p.gender',
                    DB::raw('CONCAT(first_name," ",last_name) as name'),
                    DB::raw('(SELECT name FROM hospital WHERE id = t.FK_referred_from_ID) as from_hospital'),
                    DB::raw('(SELECT name FROM hospital WHERE id = t.FK_referred_to_ID) as to_hospital'),
                )
                -> join('referral as ref', 'ref.id', 't.FK_referral_ID')
                -> join('patient as p', 'p.id','ref.FK_referral_ID')
                -> join('referral_status rf', 'rf.id', 'ref.FK_status_list_ID')
                -> get();

            return response()->json(['data'=>$transfer],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Transfer Controller[showAllTransfer] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'date' => 'required|string|max:255',
                'reason' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'date' => $request->input('date'),
                'reason' => $request->input('reason'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $transfer = new Transfer;
            $transfer -> date = $cleanData['date'];
            $transfer -> reason = $cleanData['reason'];
            $transfer -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Transfer Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showTransfer($id, Request $request)
    {
        try{
            $transfer = Transfer::find($id);

            if(!$transfer)
            {
                return response()->json(['message'=>'No transfer record found.'],404);
            }

            return response()->json(['data'=>$transfer],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Transfer Controller[showTransfer] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update(Request $request)
    {
        try{
            $transfer = Transfer::find($id);

            if(!$transfer)
            {
                return response()->json(['message'=>'No transfer record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'date' => 'required|string|max:255',
                'reason' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'date' => $request->input('date'),
                'reason' => $request->input('reason'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $transfer -> date = $cleanData['date'];
            $transfer -> reason = $cleanData['reason'];
            $transfer -> updated_at = now();
            $transfer -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Transfer Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $transfer = Transfer::find($id);

            if(!$transfer)
            {
                return response()->json(['message'=>'No transfer record found.'],404);
            }
            $transfer -> deleted = TRUE;
            $transfer -> updated_at = now();
            $transfer -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Transfer Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
