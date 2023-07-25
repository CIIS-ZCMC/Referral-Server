<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Logs;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function showMyProfile($id, Request $request)
    {
        try{
            $data = Profile::where('FK_user_ID', $id) -> first();

            if(!$data)
            {
                return response() -> json(['message' => 'Profile missing.'], 404);
            }

            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Profile Controller[showMyProfile] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function registerProfile(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string',
                'ext_name' => 'nullable|string',
                'bod' => 'required|date',
                'sex' => 'required|string',
                'contact' => 'nullable|string',
                'FK_hospital_ID' => 'nullable|integer',
                'FK_department_ID' => 'nullable|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'id' => $request->input('id'),
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'ext_name' => $request->input('ext_name'),
                'bod' => $request->input('bod'),
                'sex' => $request->input('sex'),
                'contact' => $request->input('contact'),
                'FK_hospital_ID' => $request->input('FK_hospital_ID'),
                'FK_department_ID' => $request->input('FK_department_ID'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); // strip tags to prevent XSS attack
            }

            $profile = new Profile;
            $profile -> first_name = $cleanData['first_name'];
            $profile -> middle_name = $cleanData['middle_name'];
            $profile -> last_name = $cleanData['last_name'];
            $profile -> ext_name = $cleanData['ext_name'];
            $profile -> bod = $cleanData['bod'];
            $profile -> sex = $cleanData['sex'];
            $profile -> contact = $cleanData['contact'];
            $profile -> FK_hospital_ID = $cleanData['FK_hospital_ID'];
            $profile -> FK_department_ID = $cleanData['FK_department_ID'];
            $profile -> FK_user_ID = $request -> user() -> id;
            $profile -> save();

            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Profile Controller[registerProfile] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function updateProfile($id, Request $request)
    {
        try{
            $profile = Profile::find($id);
            
            if(!$data)
            {
                return response() -> json(['message' => "Missing profile."], 404);
            }

            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string',
                'ext_name' => 'nullable|string',
                'bod' => 'required|date',
                'sex' => 'required|string',
                'contact' => 'nullable|string',
                'FK_hospital_ID' => 'nullable|integer',
                'FK_department_ID' => 'nullable|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'id' => $request->input('id'),
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'ext_name' => $request->input('ext_name'),
                'bod' => $request->input('bod'),
                'sex' => $request->input('sex'),
                'contact' => $request->input('contact'),
                'FK_hospital_ID' => $request->input('FK_hospital_ID'),
                'FK_department_ID' => $request->input('FK_department_ID'),
            ];

            $created_at = $this -> sanitizeData -> cleanDateTimeData($request['created_at']);

            if($created_at === False){
                return response() -> json(['message' => "Something went wrong."], 400);
            }
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); // strip tags to prevent XSS attack
            }


            $profile -> first_name = $cleanData['first_name'];
            $profile -> middle_name = $cleanData['middle_name'];
            $profile -> last_name = $cleanData['last_name'];
            $profile -> ext_name = $cleanData['ext_name'];
            $profile -> bod = $cleanData['bod'];
            $profile -> sex = $cleanData['sex'];
            $profile -> contact = $cleanData['contact'];
            $profile -> FK_hospital_ID = $cleanData['FK_hospital_ID'];
            $profile -> FK_department_ID = $cleanData['FK_department_ID'];
            $profile -> FK_user_ID = $request -> user() -> id;
            $profile -> save();

            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Profile Controller[registerProfile] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
}
