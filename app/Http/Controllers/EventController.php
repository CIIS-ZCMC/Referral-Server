<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\EventModel;

class EventController extends Controller
{
    public function showEvent($name, Request $request)
    {
        try{
            $event = Event::where('name', $name)->first();

            return response()->json(['data'=>$event], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Event Controller[shoEvent] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }

    public function update($name, Request $request)
    {
        try{
            $min = 1000000;
            $max = 9999999;
            $randomNumber = mt_rand($min, $max);

            $event = Event::where('name', $name)->first();
            $event -> hash = Hash::make($randomNumber);
            $event -> updated_at = now();
            $event -> save();

            return response()->json(['data'=>'Success'],200);
        }catch(\Throwable $th){
            Log::channel('custom-error')->error('Event Controller[update] :'.$th->getMessage());
            return response()->json(['message'=>$th->getMessage()],500);
        }
    }
}
