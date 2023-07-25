<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\BreastFeed;

class BreastfeedController extends Controller
{
    public function showAllBreastFeed(Request $request)
    {
        try{
            $breastfeed = BreastFeed::all();

            return response()->json(['data'=>$breastfeed],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Breastfeed Controller['showAllBreastFeed] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'date' => 'required|string|max:255',
                'from_to' => 'required|string|max:255',
                'yes' => 'required|string|max:255',
                'reason_for_no' => 'required|string|max:255',
                'management' => 'required|string|max:255',
                'attended' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'date' => $request->input('date'),
                'from_to' => $request->input('from_to'),
                'yes' => $request->input('yes'),
                'reason_for_no' => $request->input('reason_for_no'),
                'management' => $request->input('management'),
                'attended' => $request->input('attended'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $breastfeed = new BreastFeed;
            $breastfeed -> date = $cleanData['date'];
            $breastfeed -> from_to = $cleanData['from_to'];
            $breastfeed -> yes = $cleanData['yes'];
            $breastfeed -> reason_for_no = $cleanData['reason_for_no'];
            $breastfeed -> management = $cleanData['management'];
            $breastfeed -> attended = $cleanData['attended'];
            $breastfeed -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Breastfeed Controller['store] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    
    public function showBreastFeed(Request $request)
    {
        try{
            $breastfeed = BreastFeed::find($id);

            if(!$breastfeed)
            {
                return response()->json(['message'=>'No breastfeed record found.'],404);
            }

            return response()->json(['data'=>$breastfeed],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Breastfeed Controller['showBreastFeed] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $breastfeed = BreastFeed::find($id);

            if(!$breastfeed)
            {
                return response()->json(['message'=>'No breastfeed record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'date' => 'required|string|max:255',
                'from_to' => 'required|string|max:255',
                'yes' => 'required|string|max:255',
                'reason_for_no' => 'required|string|max:255',
                'management' => 'required|string|max:255',
                'attended' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'date' => $request->input('date'),
                'from_to' => $request->input('from_to'),
                'yes' => $request->input('yes'),
                'reason_for_no' => $request->input('reason_for_no'),
                'management' => $request->input('management'),
                'attended' => $request->input('attended'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $breastfeed -> date = $cleanData['date'];
            $breastfeed -> from_to = $cleanData['from_to'];
            $breastfeed -> yes = $cleanData['yes'];
            $breastfeed -> reason_for_no = $cleanData['reason_for_no'];
            $breastfeed -> management = $cleanData['management'];
            $breastfeed -> attended = $cleanData['attended'];
            $breastfeed -> updated_at = now();
            $breastfeed -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Breastfeed Controller['updated] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $breastfeed = BreastFeed::findOrFail($id);

            if(!$breastfeed)
            {
                return response()->json(['message'=>'No breastfeed record found.'],404);
            }
            $breastfeed -> deleted = TRUE;
            $breastfeed -> updated_at = now();
            $breastfeed -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Breastfeed Controller['destroy] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
