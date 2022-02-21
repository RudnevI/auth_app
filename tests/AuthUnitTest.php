<?php

use App\Http\Service\AuthenticationService;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthUnitTest extends TestCase
{
    public function testSignUp() {

        $response = AuthenticationService::signUp(['email' => 'test@test.com', 'username' => 'test', 'password' => '12345678']);

    }

    public function testFailureOnPasswordTooShort() {
        $response = AuthenticationService::signUp(['email' => 'test@test.com', 'username' => 'test', 'password' => '123456']);
        dd($response);
    }
}
