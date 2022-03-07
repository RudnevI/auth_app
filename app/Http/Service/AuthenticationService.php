<?php


namespace App\Http\Service;

use App\Models\Role;
use App\Models\User;


class AuthenticationService {







    public static function signUp($data) {

        try {









            if (!AuthenticationService::isPasswordLongEnough($data['password'])) {
                return AuthenticationService::setMessageStatusPair(
                "Password should be at least ".env('MIN_PASSWORD_LENGTH').' characters long',
                 400);

            }



            $uniqueParameters = ['email', 'username'];



            foreach($uniqueParameters as $parameter) {
                if(AuthenticationService::doesUserWithUniqueParameterAlreadyExist($parameter, $data[$parameter])) {
                    return  AuthenticationService::setMessageStatusPair('User with this '.$parameter.' already exists', 400);


                }

            }





            $userRoleId = Role::where('name', '=', 'user')->first()->id;


            // $data['hashed_password'] = Hash::make($data['password']);

            $data['role_id'] = $userRoleId;

            $user = new User();
            $user->hashed_password = $data['password'];
            $user->role_id = $userRoleId;
            $user->email = $data['email'];
            $user->username = $data['username'];





            $user->save();


       $response = array_merge(AuthenticationService::setMessageStatusPair('CREATED', 201), ["user" => $user]);

       return $response;

        } catch (\Exception $exception) {


            // return response()->json(["Message" => 'Something went wrong on the server side; check validity of sent data contact the administration for more details', 500]);
          return AuthenticationService::setMessageStatusPair($exception->getMessage(), 500);

        }
    }

    private static function setMessageStatusPair($message, $status) {
        $pair = ['message' => $message, 'status' => $status];
        return $pair;
    }


    public static function isPasswordLongEnough($password) {
        return env('MIN_PASSWORD_LENGTH') <= strlen($password);
    }

    public static function doesUserWithUniqueParameterAlreadyExist($searchParameter, $passedValue)
    {
        return User::where($searchParameter, '=', $passedValue)->first() != null;
    }

    public static function doesEmailMatchThePattern($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


}
