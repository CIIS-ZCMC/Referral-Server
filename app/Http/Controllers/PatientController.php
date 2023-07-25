<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Patient;

class PatientController extends Controller
{
    public function showViewReferralPatientOtherDetails($id, Request $request)
    {
        try{
            $patientDetails = DB::table('referral as ref')
                -> select('p.id as patient_id','c.result', 'ref.date', 'b.final_diagnosis', 'l.created_at as discharge_date')
                -> join('patient as p', 'p.id', 'ref.FK_patient_ID')
                -> join('bizzboxadmission as b', 'b.FK_referral_ID', 'ref.id')
                -> join('covid as c', 'c.FK_patient_ID','p.id')
                -> join('logs as l','l.FK_referral_ID', 'ref.id')
                -> where('ref.id', $id)
                -> where('l.FK_referral_ID', 5)
                -> first();

            return response()->json(['data'=>$patientDetails], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[showViewReferralPatientOtherDetails] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function showAllPatient(Request $request)
    {
        try{
            $patient = DB::table('patients as p')
                -> select('p.id', DB::raw("CONCAT(p.first_name,' ', p.last_name) as name"),'h.name as hospital', 'ref.date')
                -> join('referrals as ref','ref.FK_patient_ID','p.id')
                -> join('hospitals as h','h.id','ref.FK_hospital_ID')
                -> get();

            return response()->json(['data'=>$patient],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[showAllPatient] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'ext_name' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'birthdate' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
                'religion' => 'required|string|max:255',
                'occupation' => 'required|string|max:255',
                'height' => 'required|string|max:255',
                'weight' => 'required|string|max:255',
                'philhealth_no' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'ext_name' => $request->input('ext_name'),
                'gender' => $request->input('gender'),
                'birthdate' => $request->input('birthdate'),
                'civil_status' => $request->input('civil_status'),
                'nationality' => $request->input('nationality'),
                'religion' => $request->input('religion'),
                'occupation' => $request->input('occupation'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'philhealth_no' => $request->input('philhealth_no'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $patient = new Patient;
            $patient -> first_name = $cleanData['first_name'];
            $patient -> middle_name = $cleanData['middle_name'];
            $patient -> last_name = $cleanData['last_name'];
            $patient -> ext_name = $cleanData['ext_name'];
            $patient -> gender = $cleanData['gender'];
            $patient -> birthdate = $cleanData['birthdate'];
            $patient -> civil_status = $cleanData['civil_status'];
            $patient -> nationality = $cleanData['nationality'];
            $patient -> religion = $cleanData['religion'];
            $patient -> occupation = $cleanData['occupation'];
            $patient -> height = $cleanData['height'];
            $patient -> weight = $cleanData['weight'];
            $patient -> philhealth_no = $cleanData['philhealth_no'];
            $patient -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showPatient($id, Request $request)
    {
        try{
            $patient = Patient::find($id);

            if(!$patient)
            {
                return response()->json(['message'=>'No patient record found.'],404);
            }

            return response()->json(['data'=>$patient],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[showPatient] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $patient = Patient::find($id);

            if(!$patient)
            {
                return response()->json(['message'=>'No patient record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'ext_name' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'birthdate' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
                'religion' => 'required|string|max:255',
                'occupation' => 'required|string|max:255',
                'height' => 'required|string|max:255',
                'weight' => 'required|string|max:255',
                'philhealth_no' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'ext_name' => $request->input('ext_name'),
                'gender' => $request->input('gender'),
                'birthdate' => $request->input('birthdate'),
                'civil_status' => $request->input('civil_status'),
                'nationality' => $request->input('nationality'),
                'religion' => $request->input('religion'),
                'occupation' => $request->input('occupation'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'philhealth_no' => $request->input('philhealth_no'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $patient -> first_name = $cleanData['first_name'];
            $patient -> middle_name = $cleanData['middle_name'];
            $patient -> last_name = $cleanData['last_name'];
            $patient -> ext_name = $cleanData['ext_name'];
            $patient -> gender = $cleanData['gender'];
            $patient -> birthdate = $cleanData['birthdate'];
            $patient -> civil_status = $cleanData['civil_status'];
            $patient -> nationality = $cleanData['nationality'];
            $patient -> religion = $cleanData['religion'];
            $patient -> occupation = $cleanData['occupation'];
            $patient -> height = $cleanData['height'];
            $patient -> weight = $cleanData['weight'];
            $patient -> philhealth_no = $cleanData['philhealth_no'];
            $patient -> updated_at = now();
            $patient -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $patient = Patient::findOrFail($id);

            if(!$patient)
            {
                return response()->json(['message'=>'No patient record found.'],404);
            }
            $patient -> deleted = TRUE;
            $patient -> updated_at = now();
            $patient -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Patient Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
