<?php

use App\Http\Service\AuthenticationService;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthUnitTest extends TestCase
{



    private $functionNameAndExpectedValuesMap = [
        'testSignUp' => [
            'message' => 'CREATED'
        ]
        ];

    public function testSignUp() {

        $response = AuthenticationService::signUp(['email' => 'test200@test.com', 'username' => 'test200', 'password' => '12345678']);
        $expectedValues = ["message" => "CREATED", "status" => 201];

        foreach(array_keys($expectedValues) as $expectedValue) {
            $this->assertEqualsIgnoringCase($response[$expectedValue], $expectedValues[$expectedValue]);
        }
        if($response['user'] !== null) {
            $this->assertTrue(true);
        }




    }

    public function testFailureOnPasswordTooShort() {
        $response = AuthenticationService::signUp(['email' => 'test@test.com', 'username' => 'test', 'password' => '123456']);
        $message = $response["message"];
        $status = $response["status"];
        $this->assertEqualsIgnoringCase($message, "Password should be at least ".env('MIN_PASSWORD_LENGTH').' characters long');
        $this->assertEquals($status, 400);


    }

    public function testFailureOnUserWithEmailAlreadyExistent() {
        $response = AuthenticationService::signUp(['email' => 'test@test.com', 'username' => 'test', 'password' => '12345678']);
        $this->assertEqualsIgnoringCase($response['message'], 'User with this email already exists');
        $this->assertEqualsIgnoringCase($response['status'], 400);

    }
}
