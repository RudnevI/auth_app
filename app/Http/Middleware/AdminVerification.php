<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Models\User;
use Closure;
use Exception;

class AdminVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->bearerToken();
        if(empty($token)) {
            response()->json(["Message" => "Unauthorized: no token provided"], 401);
        }
        try {
            $user = Token::where('access_token', '=', $token)->get()->first()->user()->get()->first();

            $roleId = $user->role_id;

            if($roleId !== 1) {
             return response()->json(["Message" => "Unauthorized"], 401);
            }
        }
        catch(Exception $exception) {
            return response()->json(["Message" => "Unauthorized: token is not assigned to required role"], 401);
        }
        return $next($request);


    }
}
