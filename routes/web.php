<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\User;

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->get("get-all-users", function() {
    if(User::all()->count() == 0) {
        return "List is empty";
    }
    else {
        return User::all();
    }
});

$router->post("add-user", function() {
});

$router->get("var_dump", function () {
    var_dump(12345, "dafdf", "efwae");
});


