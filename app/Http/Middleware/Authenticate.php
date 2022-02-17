<?php

namespace App\Http\Middleware;

use Closure;
use Exception;


class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $bearerToken = $request->bearerToken();

        if(empty($bearerToken)) {

            return response()->json(["Message"=>"Request is unauthorized: token is empty"], 403);
        }
        $explodedToken = [];
        try {
            $explodedToken = explode(".", $bearerToken);
            if(count($explodedToken) < 3) {
                throw new Exception();
            }
        }
        catch(Exception $e) {

            return response()->json(["Message"=>"Unsupported token format"], 400);
        }
        $signature = $explodedToken[2];
        $header = $explodedToken[0];
        $payload = $explodedToken[1];



        if(!strcmp($signature, hash_hmac("sha256", $header .'.'. $payload, env("JWT_SECRET")))===0) {
            return response()->json(["Message"=>"Token is not valid"], 400);
        }
        return $next($request);

    }
}
