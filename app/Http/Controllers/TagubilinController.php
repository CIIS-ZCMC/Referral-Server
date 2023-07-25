<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Tagubilin;

class TagubilinController extends Controller
{
    public function showAllTagubilin(Request $request)
    {
        try{
            $tagubilin = Tagubilin::all();

            return response()->json(['data'=>$tagubilin],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Controller[showAllTagubilin] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'FK_tagubilin_details_ID' => 'required|string|max:255',
                'FK_result_ID' => 'required|string|max:255',
                'FK_medication_ID' => 'required|string|max:255',
                'FK_breastfeed_ID' => 'required|string|max:255',
                'FK_follow_up_ID' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'FK_tagubilin_details_ID' => $request->input('FK_tagubilin_details_ID'),
                'FK_result_ID' => $request->input('FK_result_ID'),
                'FK_medication_ID' => $request->input('FK_medication_ID'),
                'FK_breastfeed_ID' => $request->input('FK_breastfeed_ID'),
                'FK_follow_up_ID' => $request->input('FK_follow_up_ID'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $tagubilin = new Tagubilin;
            $tagubilin -> FK_tagubilin_details_ID = $cleanData['FK_tagubilin_details_ID'];
            $tagubilin -> FK_result_ID = $cleanData['FK_result_ID'];
            $tagubilin -> FK_medication_ID = $cleanData['FK_medication_ID'];
            $tagubilin -> FK_breastfeed_ID = $cleanData['FK_breastfeed_ID'];
            $tagubilin -> FK_follow_up_ID = $cleanData['FK_follow_up_ID'];
            $tagubilin -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showTagubilin($id, Request $request)
    {
        try{
            $tagubilin = Tagubilin::find($id);

            return response()->json(['data'=>$tagubilin],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Controller[showTagubilin] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $tagubilin = Tagubilin::find($id);

            if(!$tagubilin)
            {
                return response()->json(['message'=>'No tagubilin record found.'],404);
            }
            
            $validator = Validator::make($request->all(), [
                'FK_tagubilin_details_ID' => 'required|string|max:255',
                'FK_result_ID' => 'required|string|max:255',
                'FK_medication_ID' => 'required|string|max:255',
                'FK_breastfeed_ID' => 'required|string|max:255',
                'FK_follow_up_ID' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'FK_tagubilin_details_ID' => $request->input('FK_tagubilin_details_ID'),
                'FK_result_ID' => $request->input('FK_result_ID'),
                'FK_medication_ID' => $request->input('FK_medication_ID'),
                'FK_breastfeed_ID' => $request->input('FK_breastfeed_ID'),
                'FK_follow_up_ID' => $request->input('FK_follow_up_ID'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $tagubilin -> FK_tagubilin_details_ID = $cleanData['FK_tagubilin_details_ID'];
            $tagubilin -> FK_result_ID = $cleanData['FK_result_ID'];
            $tagubilin -> FK_medication_ID = $cleanData['FK_medication_ID'];
            $tagubilin -> FK_breastfeed_ID = $cleanData['FK_breastfeed_ID'];
            $tagubilin -> FK_follow_up_ID = $cleanData['FK_follow_up_ID'];
            $tagubilin -> save();

            return response()->json(['data'=>$tagubilin],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $tagubilin = Tagubilin::find($id);

            if(!$tagubilin)
            {
                return response()->json(['message'=>'No tagubilin record found.'],404);
            }
            $tagubilin -> deleted = TRUE;
            $tagubilin -> updated_at = now();
            $tagubilin -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
