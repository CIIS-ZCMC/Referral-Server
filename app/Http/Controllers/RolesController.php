<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Roles;

class RolesController extends Controller
{
    public function showAllRoles(Request $request)
    {
        try{
            $data = Roles::all();

            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[showAllRoles] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function showAllUserWithSpecificRole($roleId, Request $request)
    {
        try{
            $data = DB::table('roles as r') 
                -> select('s.email',  'r.name as role',
                    DB::RAW('CONTAT(p.first_name," ",p.last_amit) as name'),
                    DB::raw('CASE WHEN s.status == TRUE THEN Approved WHEN s.deactivate == TRUE THEN Deactivated. ELSE Pending END as status')) 
                -> join('users as s', 's.role', 'r.id')
                -> where('r.id', $roleId) -> get();
            
            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[showAllRoles] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
    
    public function showAllUserWithRole(Request $request)
    {
        try{
            $data = DB::table('roles as r') 
                -> select('s.email',  'r.name as role',
                    DB::RAW('CONTAT(p.first_name," ",p.last_amit) as name'),
                    DB::raw('CASE WHEN s.status == TRUE THEN Approved WHEN s.deactivate == TRUE THEN Deactivated. ELSE Pending END as status')) 
                -> join('users as s', 's.role', 'r.id')
                -> get();

            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[showAllRoles] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
    
    public function store($id, Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $name = strip_tags($request -> input('name'));

            $role = new Role;
            $role -> name = $name;
            $role -> save();            

            Log::channel('custom-info') -> info("Roles Controller[store] : Success.");
            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[update] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
    
    public function update($id, Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $name = strip_tags($request -> input('name'));

            $role = Role::find($id);
            $role -> name = $name;
            $role -> updated_at = now();
            $role -> save();            

            Log::channel('custom-info') -> info("Roles Controller[update] : Success.");
            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[update] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
    
    public function destroy($id, Request $request)
    {   
        try{
            $role = Role::find($id);
            $role -> deleted = TRUE;
            $role -> updated_at = now();
            $role -> save();

            Log::channel('custom-info') -> info("Roles Controller[destroy] : Success.");
            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("Roles Controller[destroy] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
}
