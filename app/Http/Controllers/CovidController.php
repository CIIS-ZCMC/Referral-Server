<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Covid;

class CovidController extends Controller
{
    public function showAllCovid(Request $request)
    {
        try{
            $covid = Covid::all();

            return response()->json(['data'=>$covid],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Covid Controller[showAllCovid] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'swab_type' => 'required|string|max:255',
                'result' => 'required|string|max:255',
                'swab_date' => 'required|string|max:255',
                'result_date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'swab_type' => $request->input('swab_type'),
                'result' => $request->input('result'),
                'swab_date' => $request->input('swab_date'),
                'result_date' => $request->input('result_date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $covid = new Covid;
            $covid -> swab_type = $cleanData['swab_type'];
            $covid -> result = $cleanData['result'];
            $covid -> swab_date = $cleanData['swab_date'];
            $covid -> result_date = $cleanData['result_date'];
            $covid -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Covid Controller[store] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showCovid($id, Request $request)
    {
        try{
            $covid = Covid::find($id);

            if(!$covid)
            {
                return response()->json(['message'=>'No covid record found.'],404);
            }

            return response()->json(['data'=>$covid],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Covid Controller[showCovid] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{  
            $covid = Covid::find($id);

            if(!$covid)
            {
                return response()->json(['message'=>'No covid record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'swab_type' => 'required|string|max:255',
                'result' => 'required|string|max:255',
                'swab_date' => 'required|string|max:255',
                'result_date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'swab_type' => $request->input('swab_type'),
                'result' => $request->input('result'),
                'swab_date' => $request->input('swab_date'),
                'result_date' => $request->input('result_date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $covid -> swab_type = $cleanData['swab_type'];
            $covid -> result = $cleanData['result'];
            $covid -> swab_date = $cleanData['swab_date'];
            $covid -> result_date = $cleanData['result_date'];
            $covid -> updated_at = now();
            $covid -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Covid Controller[update] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $covid = Covid::find($id);

            if(!$covid)
            {
                return response()->json(['message'=>'No covid record found.'],404);
            }
            $covid -> deleted = TRUE;
            $covid -> updated_at = now();
            $covid -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Covid Controller[destroy] :".$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
