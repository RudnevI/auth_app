<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


        $validatedData = $this->validate($request,[
            'full_name' => 'required',

            'bio' => 'max:1024',

        ]);



        $validatedData = $request->all();

        $userInfo = new UserInfo();
        $userInfo->full_name = $validatedData['full_name'];
        $userInfo->bio = $validatedData['bio'];
        $userInfo->isBanned = false;
        $user = User::where('email', '=', $validatedData['email'])->first();



        if($user === null) {
            return response()->json(["Message" => "User with passed email does not exist"], 400);
        }

dd(UserInfo::where('email', '=', $validatedData['email'], 'or', 'full_name', '=', $validatedData['full_name'])->first());

        if(UserInfo::where('email', '=', $validatedData['email'], 'or', 'full_name', '=', $validatedData['full_name'])->first() !== null) {
            response()->json(["Message" => "User with passed email or full name already exists"], 400);
        }

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


}
