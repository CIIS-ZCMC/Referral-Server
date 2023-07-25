<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Medication;

class MedicationController extends Controller
{
    public function showAllMedication(Request $reuqest)
    {
        try{
            $medication = Medication::all();

            return response()->json(['data'=>$medication],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Medication Controller[showAllMedication] :'.$th->getMessage());
            return reponse()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $reuqest)
    {
        try{
            $validator = Validator::make($request->all(), [
                'medicine' => 'required|string|max:255',
                'dosage' => 'required|string|max:255',
                'schedule' => 'required|string|max:255',
                'quantity' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'medicine' => $request->input('medicine'),
                'dosage' => $request->input('dosage'),
                'schedule' => $request->input('schedule'),
                'quantity' => $request->input('quantity'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $medication = new Medication;
            $medication -> medicine = $cleanData['medicine'];
            $medication -> dosage = $cleanData['dosage'];
            $medication -> schedule = $cleanData['schedule'];
            $medication -> quantity = $cleanData['quantity'];
            $medication -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Medication Controller[showAllMedication] :'.$th->getMessage());
            return reponse()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showMedication($id, Request $reuqest)
    {
        try{
            $medication = Medication::find($id);

            if(!$medication)
            {
                return response()->json(['message'=>'No medication record found'], 404);
            }

            return response()->json(['data'=>$medication],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Medication Controller[showMedication] :'.$th->getMessage());
            return reponse()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $reuqest)
    {
        try{
            $medication = Medication::find($id);

            if(!$medication)
            {
                return response()->json(['message'=>'No medication record found'], 404);
            }
            
            $validator = Validator::make($request->all(), [
                'medicine' => 'required|string|max:255',
                'dosage' => 'required|string|max:255',
                'schedule' => 'required|string|max:255',
                'quantity' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'medicine' => $request->input('medicine'),
                'dosage' => $request->input('dosage'),
                'schedule' => $request->input('schedule'),
                'quantity' => $request->input('quantity'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $medication -> medicine = $cleanData['medicine'];
            $medication -> dosage = $cleanData['dosage'];
            $medication -> schedule = $cleanData['schedule'];
            $medication -> quantity = $cleanData['quantity'];
            $medication -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Medication Controller[update] :'.$th->getMessage());
            return reponse()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $reuqest)
    {
        try{
            $medication = Medication::findOrFail($id);

            if(!$medication)
            {
                return response()->json(['message'=>'No medication record found'], 404);
            }
            $medication -> deleted = TRUE;
            $medication -> updated_at = now();
            $medication -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Medication Controller[destroy] :'.$th->getMessage());
            return reponse()->json(['message'=>$th->getMessage()],500);
        }
    }
}
