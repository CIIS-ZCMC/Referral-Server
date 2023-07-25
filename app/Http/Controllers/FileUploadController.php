<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\FileUploads;

class FileUploadController extends Controller
{
    public function showAllFileUpload(Request $request)
    {
        try{
            $fileUpload = FileUploads::all();

            return response()->json(['data'=>$fileUpload],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('File Upload Controller[showAllFileUpload] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'urls' => 'required|string|max:255',
                'details' => 'required|string|max:255',
                'date' => 'required|date|max:255'
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'urls' => $request->input('urls'),
                'details' => $request->input('details'),
                'date' => $request->input('date')
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $fileUpload = new FileUploads;
            $fileUpload -> urls = $cleanData['urls'];
            $fileUpload -> details = $cleanData['details'];
            $fileUpload -> date = $cleanData['date'];
            $fileUpload -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('File Upload Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showFileUpload($id, Request $request)
    {
        try{
            $fileUpload = FileUploads::find($id);

            if(!$fileUpload)
            {
                return response()->json(['message'=>'No file record found'], 404);
            }

            return response()->json(['data'=>$fileUpload],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('File Upload Controller[showFileUpload] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $fileUpload = FileUploads::find($id);

            if(!$fileUpload)
            {
                return response()->json(['message'=>'No file record found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'urls' => 'required|string|max:255',
                'details' => 'required|string|max:255',
                'date' => 'required|date|max:255'
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'urls' => $request->input('urls'),
                'details' => $request->input('details'),
                'date' => $request->input('date')
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $fileUpload -> urls = $cleanData['urls'];
            $fileUpload -> details = $cleanData['details'];
            $fileUpload -> date = $cleanData['date'];
            $fileUpload -> updated_at = now();
            $fileUpload -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('File Upload Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy(Request $request)
    {
        try{
            $fileUpload = FileUploads::find($id);

            if(!$fileUpload)
            {
                return response()->json(['message'=>'No file record found'], 404);
            }
            $fileUpload -> deleted = TRUE;
            $fileUpload -> updated_at = now();
            $fileUpload -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('File Upload Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
