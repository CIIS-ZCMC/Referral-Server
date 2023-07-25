<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\FollowUp;

class FollowUpController extends Controller
{
    public function showAllFollowUp(Request $request)
    {
        try{    
            $followUp = FollowUp::all();

            return response()->json(['data'=>$followUp],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('FollowUp Controller[showAllFollowUp] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'follow_up_date' => 'required|string|max:255',
                'follow_up_time' => 'required|string|max:255',
                'need_to_bring' => 'required|string|max:255',
                'nurse' => 'required|string|max:255',
                'resident' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'follow_up_date' => $request->input('follow_up_date'),
                'follow_up_time' => $request->input('follow_up_time'),
                'need_to_bring' => $request->input('need_to_bring'),
                'nurse' => $request->input('nurse'),
                'resident' => $request->input('resident'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $followUp = new FollowUp;
            $followUp -> follow_up_date = $cleanData['follow_up_date'];
            $followUp -> follow_up_time = $cleanData['follow_up_time'];
            $followUp -> need_to_bring = $cleanData['need_to_bring'];
            $followUp -> nurse = $cleanData['nurse'];
            $followUp -> resident = $cleanData['resident'];
            $followUp -> save();

            return response()->json(['data'=>$followUp],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('FollowUp Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showFollowUp($id, Request $request)
    {
        try{    
            $followUp = FollowUp::find($id);

            if(!$followUp)
            {
                return response()->json(['message'=>'No followup record found.'],404);
            }

            return response()->json(['data'=>$followUp],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('FollowUp Controller[showFollowUp] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{    
            $followUp = FollowUp::find($id);

            if(!$followUp)
            {
                return response()->json(['message'=>'No followup record found.'],404);
            }
            
            $validator = Validator::make($request->all(), [
                'follow_up_date' => 'required|string|max:255',
                'follow_up_time' => 'required|string|max:255',
                'need_to_bring' => 'required|string|max:255',
                'nurse' => 'required|string|max:255',
                'resident' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'follow_up_date' => $request->input('follow_up_date'),
                'follow_up_time' => $request->input('follow_up_time'),
                'need_to_bring' => $request->input('need_to_bring'),
                'nurse' => $request->input('nurse'),
                'resident' => $request->input('resident'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $followUp = new FollowUp;
            $followUp -> follow_up_date = $cleanData['follow_up_date'];
            $followUp -> follow_up_time = $cleanData['follow_up_time'];
            $followUp -> need_to_bring = $cleanData['need_to_bring'];
            $followUp -> nurse = $cleanData['nurse'];
            $followUp -> resident = $cleanData['resident'];
            $followUp -> updated_at = now();
            $followUp -> save();

            return response()->json(['data'=>$followUp],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('FollowUp Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{    
            $followUp = FollowUp::find($id);

            if(!$followUp)
            {
                return response()->json(['message'=>'No followup record found.'],404);
            }

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('FollowUp Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
