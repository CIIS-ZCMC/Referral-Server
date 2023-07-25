<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TagubilinDetail;

class TagubilinDetailController extends Controller
{
    public function showAllTagubilinDetail(Request $request)
    {
        try{
            $tagubilinDetail = TagubilinDetail::all();

            return response()->json(['data'=>$tagubilinDetail],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Details Controller[showAllTagubilinDetails] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'patient_name' => 'required|string|max:255',
                'birthdate' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'ward' => 'required|string|max:255',
                'hrn' => 'required|string|max:255',
                'admission_date' => 'required|string|max:255',
                'disch_date' => 'required|string|max:255',
                'disch_diagnosis' => 'required|string|max:255',
                'operation' => 'required|string|max:255',
                'surgeon' => 'required|string|max:255',
                'operation_date' => 'required|string|max:255',
                'health' => 'required|string|max:255',
                'health_others' => 'required|string|max:255',
                'instructions' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'patient_name' => $request->input('patient_name'),
                'birthdate' => $request->input('birthdate'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'ward' => $request->input('ward'),
                'hrn' => $request->input('hrn'),
                'admission_date' => $request->input('admission_date'),
                'disch_date' => $request->input('disch_date'),
                'disch_diagnosis' => $request->input('disch_diagnosis'),
                'operation' => $request->input('operation'),
                'surgeon' => $request->input('surgeon'),
                'operation_date' => $request->input('operation_date'),
                'health' => $request->input('health'),
                'health_others' => $request->input('health_others'),
                'instructions' => $request->input('instructions'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $tagubilinDetail = new TagubilinDetail;
            $tagubilinDetail -> patient_name = $cleanData['patient_name'];
            $tagubilinDetail -> birthdate = $cleanData['birthdate'];
            $tagubilinDetail -> gender = $cleanData['gender'];
            $tagubilinDetail -> address = $cleanData['address'];
            $tagubilinDetail -> ward = $cleanData['ward'];
            $tagubilinDetail -> hrn = $cleanData['hrn'];
            $tagubilinDetail -> admission_date = $cleanData['admission_date'];
            $tagubilinDetail -> disch_date = $cleanData['disch_date'];
            $tagubilinDetail -> disch_diagnosis = $cleanData['disch_diagnosis'];
            $tagubilinDetail -> operation = $cleanData['operation'];
            $tagubilinDetail -> surgeon = $cleanData['surgeon'];
            $tagubilinDetail -> operation_date = $cleanData['operation_date'];
            $tagubilinDetail -> health = $cleanData['health'];
            $tagubilinDetail -> health_others = $cleanData['health_others'];
            $tagubilinDetail -> instructions = $cleanData['instructions'];
            $tagubilinDetail -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Details Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showTagubilinDetail($id, Request $request)
    {
        try{
            $tagubilinDetail = TagubilinDetail::find($id);

            if(!$tagubilinDetail)
            {
                return response()->json(['message'=>'No tagubilin details found.'], 404);
            }

            return response()->json(['data'=>$tagubilinDetail],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Details Controller[showTagubilinDetails] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $tagubilinDetail = TagubilinDetail::find($id);

            if(!$tagubilinDetail)
            {
                return response()->json(['message'=>'No tagubilin details found.'], 404);
            }
            
            $validator = Validator::make($request->all(), [
                'patient_name' => 'required|string|max:255',
                'birthdate' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'ward' => 'required|string|max:255',
                'hrn' => 'required|string|max:255',
                'admission_date' => 'required|string|max:255',
                'disch_date' => 'required|string|max:255',
                'disch_diagnosis' => 'required|string|max:255',
                'operation' => 'required|string|max:255',
                'surgeon' => 'required|string|max:255',
                'operation_date' => 'required|string|max:255',
                'health' => 'required|string|max:255',
                'health_others' => 'required|string|max:255',
                'instructions' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'patient_name' => $request->input('patient_name'),
                'birthdate' => $request->input('birthdate'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'ward' => $request->input('ward'),
                'hrn' => $request->input('hrn'),
                'admission_date' => $request->input('admission_date'),
                'disch_date' => $request->input('disch_date'),
                'disch_diagnosis' => $request->input('disch_diagnosis'),
                'operation' => $request->input('operation'),
                'surgeon' => $request->input('surgeon'),
                'operation_date' => $request->input('operation_date'),
                'health' => $request->input('health'),
                'health_others' => $request->input('health_others'),
                'instructions' => $request->input('instructions'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $tagubilinDetail = new TagubilinDetail;
            $tagubilinDetail -> patient_name = $cleanData['patient_name'];
            $tagubilinDetail -> birthdate = $cleanData['birthdate'];
            $tagubilinDetail -> gender = $cleanData['gender'];
            $tagubilinDetail -> address = $cleanData['address'];
            $tagubilinDetail -> ward = $cleanData['ward'];
            $tagubilinDetail -> hrn = $cleanData['hrn'];
            $tagubilinDetail -> admission_date = $cleanData['admission_date'];
            $tagubilinDetail -> disch_date = $cleanData['disch_date'];
            $tagubilinDetail -> disch_diagnosis = $cleanData['disch_diagnosis'];
            $tagubilinDetail -> operation = $cleanData['operation'];
            $tagubilinDetail -> surgeon = $cleanData['surgeon'];
            $tagubilinDetail -> operation_date = $cleanData['operation_date'];
            $tagubilinDetail -> health = $cleanData['health'];
            $tagubilinDetail -> health_others = $cleanData['health_others'];
            $tagubilinDetail -> instructions = $cleanData['instructions'];
            $tagubilinDetail -> updated_at = $cleanData['updated_at'];
            $tagubilinDetail -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Details Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $tagubilinDetail = TagubilinDetail::find($id);

            if(!$tagubilinDetail)
            {
                return response()->json(['message'=>'No tagubilin details found.'], 404);
            }
            $tagubilinDetail -> deleted = TRUE;
            $tagubilinDetail -> updated_at = now();
            $tagubilinDetail -> save();

            return response()->json(['data'=> 'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Tagubilin Details Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
