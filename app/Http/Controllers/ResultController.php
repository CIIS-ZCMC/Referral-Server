<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Result;

class ResultController extends Controller
{
    public function showAllReferral(Request $request)
    {
        try{
            $result = Result::all();

            return response()->json(['data'=>$result],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Result Controller[showAllReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'laboratory' => 'required|string|max:255',
                'xray' => 'required|string|max:255',
                'ctscan' => 'required|string|max:255',
                'mri' => 'required|string|max:255',
                'other' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'laboratory' => $request->input('laboratory'),
                'xray' => $request->input('xray'),
                'ctscan' => $request->input('ctscan'),
                'mri' => $request->input('mri'),
                'other' => $request->input('other'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $result = new Result;
            $result -> laboratory = $cleanData['laboratory'];
            $result -> xray = $cleanData['xray'];
            $result -> ctscan = $cleanData['ctscan'];
            $result -> mri = $cleanData['mri'];
            $result -> other = $cleanData['other'];
            $result -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Result Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showReferral(Request $request)
    {
        try{
            $result = Result::find($id);

            if(!$result)
            {
                return response()->json(['message'=>'No result found.'],404);
            }

            return response()->json(['data'=>$result],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Result Controller[showReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $result = Result::find($id);

            if(!$result)
            {
                return response()->json(['message'=>'No result found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'laboratory' => 'required|string|max:255',
                'xray' => 'required|string|max:255',
                'ctscan' => 'required|string|max:255',
                'mri' => 'required|string|max:255',
                'other' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'laboratory' => $request->input('laboratory'),
                'xray' => $request->input('xray'),
                'ctscan' => $request->input('ctscan'),
                'mri' => $request->input('mri'),
                'other' => $request->input('other'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $result -> laboratory = $cleanData['laboratory'];
            $result -> xray = $cleanData['xray'];
            $result -> ctscan = $cleanData['ctscan']; 
            $result -> mri = $cleanData['mri'];
            $result -> other = $cleanData['other'];
            $result -> updated_at = now();
            $result -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Result Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $result = Result::findOrFail($id);

            if(!$result)
            {
                return response()->json(['message'=>'No result found.'],404);
            }
            $result -> deleted = TRUE;
            $result -> updated_at = now();
            $result -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Result Controller[showAllReferral] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
