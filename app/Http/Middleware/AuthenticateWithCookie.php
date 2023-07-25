<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\accessToken;
use App\Models\User;

class AuthenticateWithCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $accessLevel): Response
    {
        if (!$request->hasCookie('ciisToken')) {
            Log::channel('custom-warning') -> warning("Authentication NO [cookie] : [IP] ".$request -> ip()." Un-Authorized Access.");
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $datenow = date('Y-m-d H:i:s');
        $token = json_decode($request->cookie('ciisToken'));
        
        /* Check if access token expired */
        $access = DB::table("access_tokens") -> where("token", $token -> token ) -> first();

        if (count((array)$access) == 0 && strtotime($access->expiry) < $datenow) {
            Log::channel('custom-warning') -> warning("Authentication Expired [cookie] : [IP] ".$request -> ip()." Un-Authorized Access.");
            return response()->json(['error' => 'Access token has expired'], 401);
        }

        $data = ['ExtendTokenExpiration' => '1 hour'];

        /* Update access token expiry */
        if (count((array)$access) >= 1) {
            $expires = date('Y-m-d H:i:s', strtotime($data['ExtendTokenExpiration'], strtotime($access -> expiry)));
            accessToken::where('token', $token->token)->update([
                'expiry' => $expires
            ]);
        }

        /* Authenticate user */
        $user = User::find($access->userID);
        Auth::login($user);

        return $next($request, $accessLevel);
    }
}
