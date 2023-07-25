<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ObDetails;

class ObDetailsController extends Controller
{
    public function showAllObDetails(Request $request)
    {
        try{
            $obDetails = ObDetails::all();

            return response()->json(['data'=>$obDetails],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('OB Details Controller[showAllObDetails] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'gp' => 'required|string|max:255',
                'lmp' => 'required|string|max:255',
                'aog' => 'required|string|max:255',
                'edc' => 'required|string|max:255',
                'fht' => 'required|string|max:255',
                'fh' => 'required|string|max:255',
                'apgar' => 'required|string|max:255',
                'le' => 'required|string|max:255',
                'bow' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'gp' => $request->input('gp'),
                'lmp' => $request->input('lmp'),
                'aog' => $request->input('aog'),
                'edc' => $request->input('edc'),
                'fht' => $request->input('fht'),
                'fh' => $request->input('fh'),
                'apgar' => $request->input('apgar'),
                'le' => $request->input('le'),
                'bow' => $request->input('bow'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $obDetails = new ObDetails;
            $obDetails -> gp = $cleanData['gp'];
            $obDetails -> lmp = $cleanData['lmp'];
            $obDetails -> aog = $cleanData['aog'];
            $obDetails -> edc = $cleanData['edc'];
            $obDetails -> fht = $cleanData['fht'];
            $obDetails -> fh = $cleanData['fh'];
            $obDetails -> apgar = $cleanData['apgar'];
            $obDetails -> le = $cleanData['le'];
            $obDetails -> bow = $cleanData['bow'];
            $obDetails -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('OB Details Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showObDetails($id, Request $request)
    {
        try{
            $obDetails = ObDetails::find($id);

            return response()->json(['data'=>$obDetails],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('OB Details Controller[showObDetails] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $obDetails = ObDetails::find($id);

            if(!$obDetails)
            {
                return response()->json(['message'=>'No Ob Details record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'gp' => 'required|string|max:255',
                'lmp' => 'required|string|max:255',
                'aog' => 'required|string|max:255',
                'edc' => 'required|string|max:255',
                'fht' => 'required|string|max:255',
                'fh' => 'required|string|max:255',
                'apgar' => 'required|string|max:255',
                'le' => 'required|string|max:255',
                'bow' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'gp' => $request->input('gp'),
                'lmp' => $request->input('lmp'),
                'aog' => $request->input('aog'),
                'edc' => $request->input('edc'),
                'fht' => $request->input('fht'),
                'fh' => $request->input('fh'),
                'apgar' => $request->input('apgar'),
                'le' => $request->input('le'),
                'bow' => $request->input('bow'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $obDetails -> gp = $cleanData['gp'];
            $obDetails -> lmp = $cleanData['lmp'];
            $obDetails -> aog = $cleanData['aog'];
            $obDetails -> edc = $cleanData['edc'];
            $obDetails -> fht = $cleanData['fht'];
            $obDetails -> fh = $cleanData['fh'];
            $obDetails -> apgar = $cleanData['apgar'];
            $obDetails -> le = $cleanData['le'];
            $obDetails -> bow = $cleanData['bow'];
            $obDetails -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('OB Details Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $obDetails = ObDetails::find($id);

            if(!$obDetails)
            {
                return response()->json(['message'=>'No Ob Details record found.'],404);
            }
            $obDetails -> deleted = TRUE;
            $obDetails -> updated_at = now();
            $obDetails -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('OB Details Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
