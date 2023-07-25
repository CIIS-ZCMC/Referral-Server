<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Specialization;

class SpecializationController extends Controller
{
    public function showAllSpecialization(Request $request)
    {
        try{
            $specialization = Specialization::all();

            return response()->json(['data'=>$specialization],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[showAllSpecialization] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
    
    public function showSpecializationForSelection(Request $request)
    {
        try{
            $specialization = Specialization::select('id', 'title as name') -> get();

            return response()->json(['data'=>$specialization],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[showSpecializationForSelection] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'deactivated' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'deactivated' => $request->input('deactivated'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $address = new Address;
            $address -> title = $cleanData['title'];
            $address -> description = $cleanData['description'];
            $address -> status = $cleanData['status'];
            $address -> deactivated = $cleanData['deactivated'];
            $address -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[showAllSpecialization] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
    
    public function showSpecialization($id, Request $request)
    {
        try{
            $specialization = Specialization::find($id);

            if(!$specialization)
            {
                return response()->json(['message'=>'No specialization record found.'], 404);
            }

            return response()->json(['data'=>$specialization],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[showAllSpecialization] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
    
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'deactivated' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'deactivated' => $request->input('deactivated'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $specialization = new Specialization;
            $specialization -> title = $cleanData['title'];
            $specialization -> description = $cleanData['description'];
            $specialization -> status = $cleanData['status'];
            $specialization -> deactivated = $cleanData['deactivated'];
            $specialization -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[showAllSpecialization] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $specialization = Specialization::find($id);

            if(!$specialization)
            {
                return response()->json(['message'=>'No specialization record found.'], 404);
            }
            $specialization -> deleted = TRUE;
            $specialization -> updated_at = now();
            $specialization -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Specialization Controller[destroy] :'.$th->getMessage());
            return response()->json(['message' => $th->getMessage()],500);
        }
    }
}
