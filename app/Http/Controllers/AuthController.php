<?php

namespace App\Http\Controllers;

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

            $data = $request->all();
            $password_length = strlen($data['password']);

            if ($password_length < 8 || $password_length > 128) {
                return response()->json(["Message" => "Password should be between 8 and 128 characters long"], 400);
            }


            $user_with_this_email = User::where('email', $data['email'])->first();
            if ($user_with_this_email != null) {
                return response()->json(["Message" => "User with this email already exists"], 400);
            }


            if (User::where('username', $data['username'], 1)->first() != null) {
                return response()->json(["Message" => "User with this username already exists"], 400);
            }
            $userRoleId = Role::where('name', '=', 'user')->first()->id;

            // $data['hashed_password'] = Hash::make($data['password']);
            $data['role_id'] = $userRoleId;

            $user = new User();
            $user->hashed_password = $data['password'];
            $user->fill($data);
            $user->save();


            return response()->json(['Message' => 'CREATED', "user" => $user], 201);
        } catch (\Exception $exception) {


            // return response()->json(["Message" => 'Something went wrong on the server side; check validity of sent data contact the administration for more details', 500]);
            return response()->json(["Message" => $exception->getMessage(), 500]);

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
           dd($e->getMessage());
       }


       return response()->json(["token" => $token->access_token], 200);






    }

    public function testMiddleware(Request $request) {
        return response()->json(["Message", "test"]);
    }


    public function getResponseForAuthenticatedUsers(Request $request) {
        return response()->json(['Message' => 'Access granted']);
    }

    public function getAdminPage(Request $request) {
        return response()->json(["Message" => "Welcome to admin page"]);
    }


}
