<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CheckAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$accessLevel): Response
    {
        try{
            $collection = Collection::make($accessLevel);
            
            $userRoleAuthorize = $collection->contains(Auth::user() -> FK_role_ID);

            if (Auth::check() && $userRoleAuthorize) {
                return $next($request);
            }
        }catch(\Throwable $th){
            return response() -> json(['message' => $th -> getMessage()], 500);
        }

        abort(403, 'Unauthorized');
    }
}
