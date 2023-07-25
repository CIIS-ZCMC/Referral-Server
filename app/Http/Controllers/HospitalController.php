<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Hospital;

class HospitalController extends Controller
{
    public function showAllHospital(Request $request)
    {
        try{
            $hospital = Hospital::all();

            return response()->json(['data'=>$hospital],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Hospital Controller[showAllHospital] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'mscReferringCenter' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'isPrivate' => 'required|string|max:255',
                'isGovernment' => 'required|string|max:255',
                'local' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'mscReferringCenter' => $request->input('mscReferringCenter'),
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'isPrivate' => $request->input('isPrivate'),
                'isGovernment' => $request->input('isGovernment'),
                'local' => $request->input('local'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $hospital = new Address;
            $hospital -> mscReferringCenter = $cleanData['mscReferringCenter'];
            $hospital -> name = $cleanData['name'];
            $hospital -> code = $cleanData['code'];
            $hospital -> isPrivate = $cleanData['isPrivate'];
            $hospital -> isGovernment = $cleanData['isGovernment'];
            $hospital -> local = $cleanData['local'];
            $hospital -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Hospital Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showHospital($id, Request $request)
    {
        try{
            $hospital = Hospital::find($id);

            if(!$hospital)
            {
                return response()->json(['message'=>'No Hospital record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'mscReferringCenter' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'isPrivate' => 'required|string|max:255',
                'isGovernment' => 'required|string|max:255',
                'local' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'mscReferringCenter' => $request->input('mscReferringCenter'),
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'isPrivate' => $request->input('isPrivate'),
                'isGovernment' => $request->input('isGovernment'),
                'local' => $request->input('local'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $hospital -> mscReferringCenter = $cleanData['mscReferringCenter'];
            $hospital -> name = $cleanData['name'];
            $hospital -> code = $cleanData['code'];
            $hospital -> isPrivate = $cleanData['isPrivate'];
            $hospital -> isGovernment = $cleanData['isGovernment'];
            $hospital -> local = $cleanData['local'];
            $hospital -> save();

            return response()->json(['data'=>$hospital],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Hospital Controller[showHospital] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{    
            $hospital = Hospital::find($id);

            if(!$hospital)
            {
                return response()->json(['message'=>'No Hospital record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'mscReferringCenter' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'isPrivate' => 'required|string|max:255',
                'isGovernment' => 'required|string|max:255',
                'local' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'mscReferringCenter' => $request->input('mscReferringCenter'),
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'isPrivate' => $request->input('isPrivate'),
                'isGovernment' => $request->input('isGovernment'),
                'local' => $request->input('local'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $hospital -> mscReferringCenter = $cleanData['mscReferringCenter'];
            $hospital -> name = $cleanData['name'];
            $hospital -> code = $cleanData['code'];
            $hospital -> isPrivate = $cleanData['isPrivate'];
            $hospital -> isGovernment = $cleanData['isGovernment'];
            $hospital -> local = $cleanData['local'];
            $hospital -> updated_at = now();
            $hospital -> save();

            return response()->json(['data'=>$hospital],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Hospital Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $hospital = Hospital::findOrFail($id);
            
            if(!$hospital)
            {
                return response()->json(['message'=>'No Hospital record found.'],404);
            }
            $hospital -> deleted = TRUE;
            $hospital -> updated_at = now();
            $hospital -> save();

            return response()->json(['data'=>$hospital],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Hospital Controller[showAllHospital] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
