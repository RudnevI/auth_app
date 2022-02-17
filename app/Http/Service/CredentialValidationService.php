<?php

namespace App\Http\Service;

use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class CredentialValidationService
{
    public static function areCredentialsValid($email, $password): bool
    {
        try {



            $user = User::where('email', '=', $email)->firstOrFail();
            // var_dump(Hash::make($password));
            // dd($user->hashed_password.'!!!'.$password);


            if(!Hash::check($password, $user->hashed_password)) {
                return false;
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }


    }

    public static function isTokenValid($token) {
        try {
            Token::where("access_token")->firstOrFail();
        }
        catch(Exception $e) {

        }
    }


}
