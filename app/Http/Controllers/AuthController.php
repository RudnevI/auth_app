<?php

namespace App\Http\Controllers;

use App\Http\Service\AuthenticationService;
use App\Http\Service\CredentialValidationService;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signUp(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
        $result = AuthenticationService::signUp($request->all());

        $status = $result['status'];

        $message = $result['message'];

        if($status === 201) {

            return response()->json(['Message'=> $message, 'user' => $result['user']], $status);

        }
        else {

           return response()->json(['Message' => $message], $status);
        }
    }
        catch(Exception $exception) {
        return response()->json(['m' => $exception->getMessage()]);
        /* TODO: implement logging */
        }


    }



    private function generateToken($email): string
    {
        $header = ["alg" => "HS256", "typ" => "JWT"];


        $payload = ["sub" => "auth", "email" => $email];



        $encodedHeader = hash_hmac("sha256", json_encode($header), env("APP_HASH"));
        $encodedPayload = hash_hmac("sha256", json_encode($payload), env("APP_HASH"));




        $signature = hash_hmac("sha256", $encodedHeader .'.'. $encodedPayload, env("JWT_SECRET"));
        return $encodedHeader . '.' . $encodedPayload . '.' . $signature;


    }



    public function authenticate(Request $request)
    {



       if(!CredentialValidationService::areCredentialsValid($request->get('email'), $request->get('password'))) {
           return response()->json(["Message" => "Passed credentials are invalid"], 400);
       }

       $token = new Token();
       $token->access_token = $this->generateToken($request->get("email"));


        $user = User::where('email', '=', $request->get('email'))->get()->first();
        $token->user_id = $user->id;





       $token->expiration_date= Carbon::createFromTimestampMs(env("TOKEN_EXPIRATION_TIME") + Carbon::now()->valueOf());
       try {
       $token->save();
       }
       catch(Exception $e) {
      
       }


       return response()->json(["token" => $token->access_token], 200);






    }

    public function testMiddleware() {
        return response()->json(["Message", "test"]);
    }


    public function getResponseForAuthenticatedUsers() {
        return response()->json(['Message' => 'Access granted']);
    }

    public function getAdminPage() {
        return response()->json(["Message" => "Welcome to admin page"]);
    }


}
