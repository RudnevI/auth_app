<?php

namespace App\Http\Service;
use Carbon\Carbon;
use Closure;
use Exception;

class TokenService {

    /* TODO: add generate token to controllers and factories */
    public static function generateToken($header, $payload) {

        $result = '';
        foreach([$header, $payload] as $tokenElement) {
            $result = $result.hash_hmac('sha256', $tokenElement, env('APP_HASH')).'.';
        }
        $signature = hash_hmac('sha256', $header.'.'.$payload, env('JWT_SECRET'));
        $result = $result.$signature;
        return $result;


    }

    public static function getExpirationDate() {
        return Carbon::createFromTimestampMs(env("TOKEN_EXPIRATION_TIME") + Carbon::now()->valueOf());
    }


    public static function validateToken($request, Closure $next) {
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
