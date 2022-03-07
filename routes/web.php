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
use App\Http\Controllers\UserController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get("get-all-users", "UserController@getAllUsers");

$router->post("add-user", function () {

});

$router->get("var_dump", function () {
    var_dump(12345, "dafdf", "efwae");


});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('roles', ['uses' => 'RoleController@showAllroles']);

    $router->get('roles/{id}', ['uses' => 'RoleController@showOneRole']);

    $router->post('roles', ['uses' => 'RoleController@create']);

    $router->delete('roles/{id}', ['uses' => 'RoleController@delete']);

    $router->put('roles/{id}', ['uses' => 'RoleController@update']);

    $router->get('users', ['uses' => 'UserController@showAllusers']);

    $router->get('users/{id}', ['uses' => 'UserController@showOneUser']);

    $router->post('users', ['uses' => 'UserController@create']);

    $router->delete('users/{id}', ['uses' => 'UserController@delete']);

    $router->put('users/{id}', ['uses' => 'UserController@update']);

    $router->get("generate-token", ['uses' => 'AuthController@generateToken']);


    $router->get('tokens', ['uses' => 'TokenController@showAlltokens']);

    $router->get('tokens/{id}', ['uses' => 'TokenController@showOneToken']);

    $router->post('tokens', ['uses' => 'TokenController@create']);

    $router->delete('tokens/{id}', ['uses' => 'TokenController@delete']);

    $router->put('tokens/{id}', ['uses' => 'TokenController@update']);

    $router->post('sign-up', ['uses' => 'AuthController@signUp']);
    $router->post('auth', ['uses' => 'AuthController@authenticate']);
    $router->get('generate-token', ['uses' => 'AuthController@generateToken']);

    $router->get('dig-for-treasure', ['uses' => 'TreasureController@dig']);
    $router->get('test-middleware', ['uses' => 'AuthController@testMiddleware', "middleware" => "auth"]);
    $router->get('go-on-adventure', ['middleware'=>'auth', 'uses' => 'TreasureController@goOnAdventure']);
    $router->get('get-user-role-by-token', ['uses'=>'UserController@getUserRoleByToken']);
    $router->get('get-admin-page', ['middleware'=>'admin_verification', 'uses'=>'AuthController@getAdminPage']);
    $router->get('get-resource-requiring-authentication', ['middleware'=>'auth', 'uses'=>'AuthController@getResponseForAuthenticatedUsers']);
    $router->post('user-info', ['uses' => 'UserInfoController@addUserInfo']);
    $router->get('user-info', ['uses' => 'UserInfoController@getAllUserInfos']);
    $router->get('user-info-by-email', ['uses' => 'UserInfoController@getUserInfoByEmail']);
    $router->get('user-info/{id}', ['uses' => 'UserInfoController@getUserInfoById']);
    $router->put('user-info', ['uses' => 'UserInfoController@updateUserInfoByEmail']);
    $router->put('user-info/{id}', ['uses' => 'UserInfoController@updateUserInfoById']);


    $router->get('comments', ['uses' => 'CommentController@getAll']);

    $router->get('comments/{id}', ['uses' => 'CommentController@getById']);

    $router->post('comments', ['uses' => 'CommentController@create']);

    $router->delete('comments/{id}', ['uses' => 'CommentController@deleteById']);

    $router->put('comments/{id}', ['uses' => 'CommentController@updateById']);


    $router->get('ban-appeals', ['uses' => 'BanAppealController@getAll']);

    $router->get('ban-appeals/{id}', ['uses' => 'BanAppealController@getById']);

    $router->post('ban-appeals', ['uses' => 'BanAppealController@create']);

    $router->delete('ban-appeals/{id}', ['uses' => 'BanAppealController@deleteById']);

    $router->put('ban-appeals/{id}', ['uses' => 'BanAppealController@updateById']);


});



