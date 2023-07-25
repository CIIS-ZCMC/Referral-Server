<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Logs;

use App\Models\Address;
use App\Models\Profile;
use App\Models\User;

class AddressController extends Controller
{
    Public function showPersonAddress($id, Request $request)
    {
        try{
            $user = User::find($id);

            $address = Profile::where('FK_user_ID', $user['id'])
                -> join('address as a', 'profile.FK_address_ID','a.id')
                -> first();

            return response() -> json(['data' => $address], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Address Controller[showPersonAddress] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'street' => 'required|string|max:255',
                'barangay' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'street' => $request->input('street'),
                'barangay' => $request->input('barangay'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $address = new Address;
            $address -> street = $cleanData['street'];
            $address -> barangay = $cleanData['barangay'];
            $address -> city = $cleanData['city'];
            $address -> province = $cleanData['province'];
            $address -> save();

            return response() -> json(['data' => $address], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Address Controller[store] :".$th -> getMessage());
            return response() -> json(['message' => $th->getMessage()], 500);
        }
    }
    

    public function updatePersonAddress($id, Request $request)
    {
        try{
            $address = Address::find($id);

            if(!$address)
            {
                return response()->json(['message'=>'No address found.'], 404);
            }
            
            $validator = Validator::make($request->all(), [
                'street' => 'required|string|max:255',
                'barangay' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'street' => $request->input('street'),
                'barangay' => $request->input('barangay'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $address -> street = $cleanData['street'];
            $address -> barangay = $cleanData['barangay'];
            $address -> city = $cleanData['city'];
            $address -> province = $cleanData['province'];
            $address -> save();

        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Address Controller[updatePersonAddress] :".$th -> getMessage());
            return response() -> json(['message' => $th->getMessage()], 500);
        }
    }
}
