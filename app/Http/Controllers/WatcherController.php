<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Watcher;

class WatcherController extends Controller
{
    public function showAllWatcher(Request $request)
    {
        try{
            $watcher = Watcher::all();

            return response()->json(['data'=>$watcher],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Watcher Controller[showAllWatcher] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'relationship' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'name' => $request->input('name'),
                'contact' => $request->input('contact'),
                'relationship' => $request->input('relationship'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $watcher = new Watcher;
            $watcher -> name = $cleanData['name'];
            $watcher -> contact = $cleanData['contact'];
            $watcher -> relationship = $cleanData['relationship'];
            $watcher -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Watcher Controller[store] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function showWatcher($id, Request $request)
    {
        try{
            $watcher = Watcher::find($id);

            if(!$watcher)
            {
                return response()->json(['message'=>'No watcher record found.'],404);
            }

            return response()->json(['data'=>$watcher],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Watcher Controller[showWatcher] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $watcher = Watcher::find($id);

            if(!$watcher)
            {
                return response()->json(['message'=>'No watcher record found.'],404);
            }
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'relationship' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'name' => $request->input('name'),
                'contact' => $request->input('contact'),
                'relationship' => $request->input('relationship'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $watcher -> name = $cleanData['name'];
            $watcher -> contact = $cleanData['contact'];
            $watcher -> relationship = $cleanData['relationship'];
            $watcher -> updated_at = now();
            $watcher -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Watcher Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
    
    public function destroy($id, Request $request)
    {
        try{
            $watcher = Watcher::find($id);

            if(!$watcher)
            {
                return response()->json(['message'=>'No watcher record found.'],404);
            }
            $watcher -> deleted = TRUE;
            $watcher -> updated_at = now();
            $watcher -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Watcher Controller[destroy] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
