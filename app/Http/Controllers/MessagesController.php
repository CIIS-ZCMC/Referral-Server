<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Model\Messages;

class MessagesController extends Controller
{

    public function showAllMessagesOfReferral($id, Request $request)
    {
        try{
            $messages = DB::table('messages as m')
                -> select('m.id', 'm.content', 'm.date', 'h.name as hospital', 'u.profile',
                    DB::raw('CONCAT(first_name," ", last_name) as name'))
                -> join('referral as ref', 'ref.id', 'm.FK_referral_ID')
                -> join('users as u', 'u.id', 'm.FK_user_ID')
                -> join('profile as p', 'p.FK_user_ID', 'u.id')
                -> join('hospitals as h', 'h.id', 'p.FK_hospital')
                -> where('m.FK_referral_ID', $id)
                -> get();

            return response()->json(['data'=>$messages],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Messages Controller[showAllMessages] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'content' => 'required|string|max:255',
                'date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'content' => $request->input('content'),
                'date' => $request->input('date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $messages = new Messages;
            $messages -> content = $cleanData['content'];
            $messages -> date = $cleanData['date'];
            $messages -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Messages Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showMessage($id, Request $request)
    {
        try{
            $message = Messages::find($id);

            if(!$message)
            {
                return response()->json(['message'=>'No message found.'], 404);
            }

            return response()->json(['data'=>$message],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Messages Controller[showMessage] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update(Request $request)
    {
        try{
            $message = Messages::find($id);

            if(!$message)
            {
                return response()->json(['message'=>'No message found.'], 404);
            }
            
            $validator = Validator::make($request->all(), [
                'content' => 'required|string|max:255',
                'date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'content' => $request->input('content'),
                'date' => $request->input('date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $messages -> content = $cleanData['content'];
            $messages -> date = $cleanData['date'];
            $messages -> updated_at = now();
            $messages -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Messages Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $message = Messages::find($id);

            if(!$message)
            {
                return response()->json(['message'=>'No message found.'], 404);
            }
            
            $message -> deleted = TRUE;
            $message -> updated_at = now();
            $message -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Messages Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
