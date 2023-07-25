<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

use App\Models\User;
use App\Models\AccessToken;
use App\Models\Profile;

class UserController extends Controller
{
    protected $cookieName = 'referralToken';

    public function signIn(Request $request)
    {  
        try{

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $json = file_get_contents(resource_path('config/config.json'));
            $data = json_decode($json, true);

            $accesstoken = hash('sha256', Str::random(40));
            $expires = date('Y-m-d H:i:s', strtotime($data['TokenExpiration']));

            $user = User::where('email', $cleanData['email'])->first();

            if(!Hash::check($cleanData['password'].env('SALT_VALUE'), $user['password']))
            {
                return response() -> json(['message' => 'UnAuthenticated'], 401);
            }
            
            if(!$user -> deleted)
            {
                return response() -> json(['message' => 'Account deleted.'], 401);
            }
            
            if(!$user -> deactivate)
            {
                return response() -> json(['message' => 'Account deactivated.'], 302);
            }

            if(!$user -> status)
            {
                return response() -> json(['message' => "Pending Account."], 401);
            }

            $hasToken = AccessToken::where('FK_user_ID', $user['id']) -> first();

            if(!$hasToken)
            {
                $hasToken->create(['userId' => $user['id'],'token' => $accesstoken,'expiry' => $expires]);       
            }else{
                $hasToken->update(['token'=> $accesstoken,'expiry' => $expires]);
            }

            $profile = Profile::select(DB::raw('CONCAT(first_name, last_name) as name'),'sex','contact')
                ->where('FK_user_ID', $user['id']) -> first();            

            return response() -> json(['data' => $profile ])
                ->cookie($cookieName, json_encode(['token' => $accesstoken, 'role' => $user['role']]), 180, env('SESSION_DOMAIN'), null, true);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[signIn] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function signUp(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'image_url' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'image_url' => $request->input('image_url'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); 
            }

            $user = new User;
            $user -> image_url = $cleanData['image_url'];
            $user -> email = $cleanData['email'];
            $user -> passsword = Hash::make($cleanData['password'].env("SALT_VALUE"));
            $user -> save();

            Log::channel('custom-info') -> info("User Controller[signUp] : NEW USER REGISTERED ".$user['email'].'.');
            return response() -> json(['data' => "Please wait for approval."], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[signUp] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function signOut(Request $request)
    {
        try{
            $accesstoken = AccessToken::where('userID', $user['id'])->first();
            $accesstoken -> delete();

            return response() -> json(['data' => 'Success'], 200) -> withCookie(Cookkie::forget($cookieName));
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[signOut] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function activateAccount(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $email = strip_tags($request['email']);

            $user = User::where('email', $email) -> first();
            $user -> status = TRUE;
            $user -> updated_at = now();
            $user -> save();

            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[updateUserStatus] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function showAllUser(Request $request)
    {
        try{
            $data = DB::table('users as s')
                -> select('s.id', 's.email','s.image_url','s.created_at as date',
                    DB::RAW('CONTAT(p.first_name," ",p.last_amit) as name'),
                    DB::raw('CASE WHEN s.status == TRUE THEN Approved WHEN s.deactivate == TRUE THEN Deactivated. ELSE Pending END as status'))
                -> join('profile as p','p.FK_user_ID', 's.id') -> get();

            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[showAll] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function showUser($id, Request $request)
    {
        try{
            $data = DB::table('users as s')
                -> select('s.id', 's.email','s.image_url','s.created_at as date',
                    DB::RAW('CONTAT(p.first_name," ",p.last_amit) as name'),
                    DB::raw('CASE WHEN s.status === TRUE THEN Approved WHEN s.deactivate === TRUE THEN Deactivated. ELSE Pending END as status'))
                -> join('profile as p','p.FK_user_ID', 's.id')
                -> where('s.id', $id)
                -> first();

            if(!$data)
            {
                return response() -> json(['message' => 'No account found.'], 404);
            }

            return response() -> json(['data' => $data], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[show] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function updatePassword( Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'oldPassword' => 'required|string|max:255',
                'newPassword' => 'required|string|max:255'
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $data = [
                'oldPassword' => $request->input('oldPassword'),
                'newPassword' => $request->input('newPassword')
            ];
            
            $cleanData = [];

            foreach ($data as $key => $value) {
                $cleanData[$key] = strip_tags($value); // strip tags to prevent XSS attack
            }

            $user = $request -> user();           
            
            $credentials = [
                'email'     => $email,
                'password'  => $cleanData['oldPassword']
            ];
            
            if(!Hash::check($cleanData['password'].env('SALT_VALUE'),$user['password']))
            {
                return response() -> json(['data' => 'Wrong password.'], 400);
            }

            $user -> passsword = Hash::make($cleanData['newPassword'].env("SALT_VALUE"));
            $user -> updated_at = now();
            $user -> save();

            Log::channel('custom-info') -> info("User Controller[update] : PASSWORD UPDATED ".$user['email'].'.');
            return response() -> json(['message' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[update] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function deactivate(Request $request)
    {
        try{
            $user = $request -> user();
            $user -> deactivate = TRUE;
            $user -> updated_at = now();
            $user -> save();

            Log::channel('custom-info') -> info("User Controller[deactivate] : ACCOUNT DEACTIVATED ".$user['email'].'.');
            return response() -> json(['data' => 'Succcess'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[deactivate] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function sendEmailOTP(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255',
            ]);           
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $email = strip_tags($request['email']);

            $user = User::where('email', $email) -> first();
            
            if(!$user)
            {
                return response() -> json(['message' => 'No Account found.'], 404);
            }
            
            $otp = rand(100000,999999);
            $request -> session() -> put('otp', $otp);

            $user -> otp = $otp;
            $user -> otp_exp = now();
            $user -> updated_at = now();
            $user -> save();

            Log::channel('custom-info') -> info("User Controller[sendEmailOTP] : SENT OTP CODE ".$user['email'].'.');
            return redirect()->route('mail.sendPasswordresetcode', ["email" => $email, "username" => $user -> name, "reset_code" => $reset_code]);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[sendEmailOTP] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function validateOTP(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255',
                'otp' => 'required|integer'
            ]);           
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $email = strip_tags($request['email']);
            $otp = strip_tags($request['otp']);

            $user = User::where('email', $email) -> first();
            
            if(!$user)
            {
                return response() -> json(['message' => 'No Account found.'], 404);
            }

            $expires_at = Carbon::parse($user['otp']);
            $now = Carbon::now();


            if($now->gt($expires_at) && $user -> otp != $otp)
            {
                return response() -> json(['message' => 'OTP already expried.'], 400);
            }

            if($user -> otp != $otp)
            {
                return response() -> json(['message' => "Code doesn't match."], 400);
            } 

            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[validateOTP] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function updateNewPassword(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255',
                'password' => 'required|string'
            ]);           
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $password = Hash::make($request['password'].env('SALT_VALUE'));

            $user = User::where('email', $request['email']) -> first();

            if(!$user)
            {
                return response() -> json(['message' => "No account found."], 404);
            }

            $user -> password = $password;
            $user -> updated_at = now();
            $user -> save();
            
            Log::channel('custom-info') -> info("User Controller[updateNewPassword] : PASSWORD UPDATED ".$user['email'].'.');
            return response() -> json(['data' => 'Success'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[updateNewPassword] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }

    public function destroy($id, Request $request)
    {
        try{
            $user = User::findOrFail($id);

            $user -> deleted = TRUE;
            $user -> updated_at = now();
            $user -> save();

            Log::channel('custom-info') -> info("User Controller[destroy] : ACCOUNT DELETED ".$user['email'].'.');
            return response() -> json(['message' => 'Success.'], 200);
        }catch(\Throwable $th){
            Log::channel('custom-error') -> error("User Controller[destroy] :".$th -> getMessage());
            return response() -> json(['message' => $th -> getMessage()], 500);
        }
    }
}
