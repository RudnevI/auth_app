<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Http\Request as HttpRequest;

class UserInfoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function addUserInfo(Request $request) {


        try {
        $validatedData = $this->validate($request,[
            'full_name' => 'required',
            'email' => 'required',
            'bio' => 'max:1024',

        ]);
    }
    catch(Exception $exception) {
        dd($exception->getMessage());
    }



        $validatedData = $request->all();

        $userInfo = new UserInfo();
        $userInfo->full_name = $validatedData['full_name'];
        $userInfo->bio = $validatedData['bio'];
        $userInfo->isBanned = false;

        $user = User::where('email', '=', $validatedData['email'])->first();



        if($user === null) {
            return response()->json(["Message" => "User with passed email does not exist"], 400);
        }




        try{
        if(UserInfo::where($user->email === $validatedData['email'] || UserInfo::where('full_name', '=', $validatedData['full_name'])->first() !== null )) {
           return response()->json(["Message" => "User info section with passed email or full name already exists"], 400);
        }
    }
    catch(Exception $exception) {
        dd($exception->getMessage());
    }
        dd("test");
        $userInfo->user_id = $user->id;
        try {
        $userInfo->save();
        return response()->json(["Message" => "CREATED", 'user_info' => $userInfo], 200);
        } catch(Exception $exception) {
            dd($exception->getMessage());
            Log::error($exception->getMessage());
            return response()->json(["Message" => "Something went wrong"], 500);
        }


    }

    public function getAllUserInfos() {
        return response()->json([UserInfo::all()], 200);
    }

    public function getUserInfoByEmail(Request $request) {


            // $validatedData = Validator::make($request->all(), [
            //     'email' => 'required'
            // ])->validate('email');




            if(!in_array('email', $request->all())) {
                return response()->json(["Message" => "Email is required"], 400);
            }
            $validatedData = $request->all();



        $user = User::where('email', $validatedData['email'])->first();
        if($user === null) {
            return response()->json(["Message" => "User with this email does not exist"], 400);
        }

        return response()->json([UserInfo::where('user_id', $user->id)->first()]);
    }

    public function updateUserInfoByEmail(Request $request) {

        try {
            $validatedData = $this->validate($request,[
                'full_name' => 'required',
                'email' => 'required',
                'bio' => 'max:1024',

            ]);
        }
        catch(Exception $exception) {
            dd($exception->getMessage());
        }



            $validatedData = $request->all();

            $userInfo = UserInfo::where('email', $validatedData['email']);
            if($userInfo === null) {
                return response()->json(["Message" => "User section about user with passed email does not exist"], 400);
            }

            $userInfo->full_name = $validatedData['full_name'];
            $userInfo->email = $validatedData['email'];
            $userInfo->bio = $validatedData['bio'];
            $userInfo->save();










    }

    public function deleteUserInfoByEmail(Request $request) {
        if(!in_array('email', $request->all())) {
            return response()->json(["Message" => "Email is required"], 400);
        }

        $validatedData = $request->all();

        $user = User::where('email', $validatedData['email'])->first();
        if($user === null) {
            return response()->json(["Message" => "User with this email does not exist"], 400);
        }


        $userInfo = UserInfo::where('user_id', $user->user_id)->first();

        if($userInfo === null) {
            return response()->json(["Message" => "User info section about this user does not exist"], 400);

        }

        $userInfo->delete();
    }


}
