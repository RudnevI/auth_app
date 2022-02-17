<?php

namespace App\Http\Service;
use Carbon\Carbon;

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
}
