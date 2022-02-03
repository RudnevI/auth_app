<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers() {

        if(User::all()->count() == 0) {
            return "List is empty";
        }
        else {
            return User::all();
        }
    }
}
