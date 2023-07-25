<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Admitting;

class AdmittingController extends Controller
{
    public function showAllAdmission(Request $request)
    {
        try{
            $admitting = Admitting::all();

            return response()->json(['data'=>$admitting],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admitting Controler["showAllAdmission] :"'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'admitted' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'disposition' => 'required|string|max:255',
                'temperature' => 'required|string|max:255',
                'blood_pressure' => 'required|string|max:255',
                'respiratory_rate' => 'required|string|max:255',
                'pulse_rate' => 'required|string|max:255',
                'oxygen' => 'required|string|max:255',
                'o2_sat' => 'required|string|max:255',
                'gcs' => 'required|string|max:255',
                'chief_complaints' => 'required|string|max:255',
                'diagnosis' => 'required|string|max:255',
                'endorsement' => 'required|string|max:255',
                'referring_ROD' => 'required|string|max:255',
                'reason' => 'required|string|max:255',
                'patient_history' => 'required|string|max:255',
                'pertinent_pe' => 'required|string|max:255',
                'lvf' => 'required|string|max:255',
                'labs' => 'required|string|max:255',
                'meds' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'admitted' => $request->input('admitted'),
                'type' => $request->input('type'),
                'disposition' => $request->input('disposition'),
                'temperature' => $request->input('temperature'),
                'blood_pressure' => $request->input('blood_pressure'),
                'respiratory_rate' => $request->input('respiratory_rate'),
                'pulse_rate' => $request->input('pulse_rate'),
                'oxygen' => $request->input('oxygen'),
                'o2_sat' => $request->input('o2_sat'),
                'gcs' => $request->input('gcs'),
                'chief_complaints' => $request->input('chief_complaints'),
                'diagnosis' => $request->input('diagnosis'),
                'endorsement' => $request->input('endorsement'),
                'referring_ROD' => $request->input('referring_ROD'),
                'reason' => $request->input('reason'),
                'patient_history' => $request->input('patient_history'),
                'pertinent_pe' => $request->input('pertinent_pe'),
                'lvf' => $request->input('lvf'),
                'labs' => $request->input('labs'),
                'meds' => $request->input('meds'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $admitting = new Admitting;
            $admitting -> admitted = $cleanData['admitted'];
            $admitting -> type = $cleanData['type'];
            $admitting -> disposition = $cleanData['disposition'];
            $admitting -> temperature = $cleanData['temperature'];
            $admitting -> blood_pressure = $cleanData['blood_pressure'];
            $admitting -> respiratory_rate = $cleanData['respiratory_rate'];
            $admitting -> pulse_rate = $cleanData['pulse_rate'];
            $admitting -> oxygen = $cleanData['oxygen'];
            $admitting -> o2_sat = $cleanData['o2_sat'];
            $admitting -> gcs = $cleanData['gcs'];
            $admitting -> chief_complaints = $cleanData['chief_complaints'];
            $admitting -> diagnosis = $cleanData['diagnosis'];
            $admitting -> endorsement = $cleanData['endorsement'];
            $admitting -> referring_ROD = $cleanData['referring_ROD'];
            $admitting -> reason = $cleanData['reason'];
            $admitting -> patient_history = $cleanData['patient_history'];
            $admitting -> pertinent_pe = $cleanData['pertinent_pe'];
            $admitting -> lvf = $cleanData['lvf'];
            $admitting -> labs = $cleanData['labs'];
            $admitting -> meds = $cleanData['meds'];
            $admitting -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admitting Controler["store] :"'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    public function showAdmission($id, Request $request)
    {
        try{
            $admitting = Admitting::find($id);

            if(!$admitting)
            {
                return response()->json(['message'=>'No admitting record found.'], 404);
            }

            return response()->json(['data'=>$admitting],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admitting Controler["showAdmission] :"'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    public function update($id, Request $request)
    {
        try{
            $admitting = Admitting::find($id);

            if(!$admitting)
            {
                return response()->json(['message'=>'No admitting record found.'],404);
            }

            $validator = Validator::make($request->all(), [
                'admitted' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'disposition' => 'required|string|max:255',
                'temperature' => 'required|string|max:255',
                'blood_pressure' => 'required|string|max:255',
                'respiratory_rate' => 'required|string|max:255',
                'pulse_rate' => 'required|string|max:255',
                'oxygen' => 'required|string|max:255',
                'o2_sat' => 'required|string|max:255',
                'gcs' => 'required|string|max:255',
                'chief_complaints' => 'required|string|max:255',
                'diagnosis' => 'required|string|max:255',
                'endorsement' => 'required|string|max:255',
                'referring_ROD' => 'required|string|max:255',
                'reason' => 'required|string|max:255',
                'patient_history' => 'required|string|max:255',
                'pertinent_pe' => 'required|string|max:255',
                'lvf' => 'required|string|max:255',
                'labs' => 'required|string|max:255',
                'meds' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'admitted' => $request->input('admitted'),
                'type' => $request->input('type'),
                'disposition' => $request->input('disposition'),
                'temperature' => $request->input('temperature'),
                'blood_pressure' => $request->input('blood_pressure'),
                'respiratory_rate' => $request->input('respiratory_rate'),
                'pulse_rate' => $request->input('pulse_rate'),
                'oxygen' => $request->input('oxygen'),
                'o2_sat' => $request->input('o2_sat'),
                'gcs' => $request->input('gcs'),
                'chief_complaints' => $request->input('chief_complaints'),
                'diagnosis' => $request->input('diagnosis'),
                'endorsement' => $request->input('endorsement'),
                'referring_ROD' => $request->input('referring_ROD'),
                'reason' => $request->input('reason'),
                'patient_history' => $request->input('patient_history'),
                'pertinent_pe' => $request->input('pertinent_pe'),
                'lvf' => $request->input('lvf'),
                'labs' => $request->input('labs'),
                'meds' => $request->input('meds'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $admitting -> admitted = $cleanData['admitted'];
            $admitting -> type = $cleanData['type'];
            $admitting -> disposition = $cleanData['disposition'];
            $admitting -> temperature = $cleanData['temperature'];
            $admitting -> blood_pressure = $cleanData['blood_pressure'];
            $admitting -> respiratory_rate = $cleanData['respiratory_rate'];
            $admitting -> pulse_rate = $cleanData['pulse_rate'];
            $admitting -> oxygen = $cleanData['oxygen'];
            $admitting -> o2_sat = $cleanData['o2_sat'];
            $admitting -> gcs = $cleanData['gcs'];
            $admitting -> chief_complaints = $cleanData['chief_complaints'];
            $admitting -> diagnosis = $cleanData['diagnosis'];
            $admitting -> endorsement = $cleanData['endorsement'];
            $admitting -> referring_ROD = $cleanData['referring_ROD'];
            $admitting -> reason = $cleanData['reason'];
            $admitting -> patient_history = $cleanData['patient_history'];
            $admitting -> pertinent_pe = $cleanData['pertinent_pe'];
            $admitting -> lvf = $cleanData['lvf'];
            $admitting -> labs = $cleanData['labs'];
            $admitting -> meds = $cleanData['meds'];
            $admitting -> updated_at = now();
            $admitting -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admitting Controler["update] :"'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function destroy($id, Request $request)
    {
        try{
            $admitting = Admitting::findOrFail($id);

            if(!$admitting)
            {
                return response()->json(['message'=>'No admitting record found.'],404);
            }
            $admitting -> deleted = TRUE();
            $admitting -> updated_at = now();
            $admitting -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Admitting Controler["destroy] :"'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
