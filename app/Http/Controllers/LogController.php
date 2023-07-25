<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Logs;

class LogController extends Controller
{
    public function showAllLogs(Request $request)
    {
        try{
            $logs = Logs::all();

            return response()->json(['data'=>$logs],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Log Controller[showAllLogs] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }   
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'description' => 'required|string|max:255',
                'referred' => 'required|string|max:255',
                'accepted' => 'required|string|max:255',
                'arrival' => 'required|string|max:255',
                'view' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'description' => $request->input('description'),
                'referred' => $request->input('referred'),
                'accepted' => $request->input('accepted'),
                'arrival' => $request->input('arrival'),
                'view' => $request->input('view'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $logs = new Logs;
            $logs -> description = $cleanData['description'];
            $logs -> referred = $cleanData['referred'];
            $logs -> accepted = $cleanData['accepted'];
            $logs -> arrival = $cleanData['arrival'];
            $logs -> view = $cleanData['view'];
            $logs -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Log Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }   
    
    public function showLog($id, Request $request)
    {
        try{
            $logs = Logs::find($id);

            if(!$logs)
            {
                return response()->json(['message'=>'No logs record found.'],404);
            }

            return response()->json(['data'=>$logs],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Log Controller[showLog] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }   
    
    public function update($id, Request $request)
    {
        try{
            $logs = Logs::find($id);

            if(!$logs)
            {
                return response()->json(['message'=>'No logs record found.'],404);
            }

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Log Controller[showAllLogs] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }   
    
    public function destroy(Request $request)
    {
        try{
            $logs = Logs::find($id);

            if(!$logs)
            {
                return response()->json(['message'=>'No logs record found.'],404);
            }
            $logs -> deleted = TRUE;
            $logs -> updated_at = now();
            $logs -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Log Controller[showAllLogs] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }   
}
