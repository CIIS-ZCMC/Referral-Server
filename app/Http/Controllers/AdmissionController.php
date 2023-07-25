<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function showAllAdmission(Request $request)
    {
        try{
            $admission = Admission::all();

            return response() -> json(['data' => $admission],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admission Controller[showAllAdmission] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'register_date' => 'required|string|max:255',
                'disch_diagnosis' => 'required|string|max:255',
                'final_diagnosis' => 'required|string|max:255',
                'disch_date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'register_date' => $request->input('register_date'),
                'disch_diagnosis' => $request->input('disch_diagnosis'),
                'final_diagnosis' => $request->input('final_diagnosis'),
                'disch_date' => $request->input('disch_date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $admission = new Address;
            $admission -> register_date = $cleanData['register_date'];
            $admission -> disch_diagnosis = $cleanData['disch_diagnosis'];
            $admission -> final_diagnosis = $cleanData['final_diagnosis'];
            $admission -> disch_date = $cleanData['disch_date'];
            $admission -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admission Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function showAdmission($id, Request $request)
    {
        try{
            $admission = Admission::find($id);

            return response() -> json(['data' => $admission],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admission Controller[showAdmission] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function update($id, Request $request)
    {
        try{
            $admission = Address::find($id);

            if(!$admission)
            {
                return response() -> json(['message' => 'No admission found.'], 404);
            }

            $validator = Validator::make($request->all(), [
                'register_date' => 'required|string|max:255',
                'disch_diagnosis' => 'required|string|max:255',
                'final_diagnosis' => 'required|string|max:255',
                'disch_date' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'register_date' => $request->input('register_date'),
                'disch_diagnosis' => $request->input('disch_diagnosis'),
                'final_diagnosis' => $request->input('final_diagnosis'),
                'disch_date' => $request->input('disch_date'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $admission -> register_date = $cleanData['register_date'];
            $admission -> disch_diagnosis = $cleanData['disch_diagnosis'];
            $admission -> final_diagnosis = $cleanData['final_diagnosis'];
            $admission -> disch_date = $cleanData['disch_date'];
            $admission -> updated_at = now();
            $admission -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admission Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function destroy($id, Request $request)
    {
        try{
            $admission = Address::findOrFail($id);
            
            if(!$admission)
            {
                return response() -> json(['message' => 'No admission found.'], 404);
            }

            $admission -> deleted = TRUE;
            $admission -> updated_at = now();
            $admission -> save();

            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error("Admission Controller[destroy] :".$th->getMessage());
            return response() -> json(['message' => $th->getMessage()],500);
        }
    }
}
