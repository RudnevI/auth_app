<?php

use App\Http\Service\TokenService;
use App\Models\Role;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class SignUpTest extends TestCase
{





    private $username = 'test_user';
    private $email = 'test_user@test.com';


    private $correctPassword = '12345678';
    private $incorrectPassword = '12332112';
    private $roleNames = ['admin', 'user', 'moderator'];
    private $shortPassword = '111';
    private $validUserObject = ['username' => 'test_user', 'email' => 'test_user@test.com', 'password' => '12345678'];
    private $userObjectWithInvalidEmail = ['username' => 'test_user', 'email' => 'test_user_invalid@test.com', 'password' => '12345678'];
    private $userObjectWithInvalidPassword = ['username' => 'test_user', 'email' => 'test_user_invalid@test.com', 'password' => '87654321'];



//Helpers

    private function getShortPasswordUserObject() {
        $obj = $this->validUserObject;
        $obj['password'] = $this->shortPassword;
        return $obj;

    }

    private function getUserWithSameEmailButDifferentUsername() {
        $obj = $this->validUserObject;
        $obj['username'] = 'test_user_different';
        return $obj;
    }

    private function getUserWithSameUsernameButDifferentEmail() {
        $obj = $this->validUserObject;
        $obj['email'] = 'test_user_different@test.com';
        return $obj;
    }

    // private function createRoles() {
    //     $roleNames = ['admin', 'user'];
    //     foreach($roleNames as $roleName) {
    //         Role::create(['name' => $roleName]);
    //     }
    // }


    private function createAdminUser() {
        // //$this->createRoles();
        $adminRoleId = Role::where('name', '=', 'admin')->first()->id;
        User::create(['username' => 'admin', 'email' => 'admin@admin.com', 'password' => '12345678', 'role_id' => $adminRoleId]);
    }
//End helpers

    public function testSignUp()
    {




        // //$this->createRoles();



        $this->json('POST', '/api/sign-up', $this->validUserObject)->seeJson(["Message" => "CREATED", 'username' => $this->username, 'email' => $this->email ]);
        $this->assertResponseStatus(201);



    }

    public function testSignUpFailureOnShortPassword() {
        //$this->createRoles();
        $this->json('POST', '/api/sign-up', $this->getShortPasswordUserObject())->seeJson(["Message" => "Password should be at least ".env('MIN_PASSWORD_LENGTH').' characters long'])->assertResponseStatus(400);
    }

    public function testSignUpFailureOnEmailAlreadyExistent() {
        //$this->createRoles();



        $this->json('POST', '/api/sign-up', $this->validUserObject);

        $this->json('POST', '/api/sign-up', $this->getUserWithSameEmailButDifferentUsername())->seeJson(["Message" => "User with this email already exists"])->assertResponseStatus(400);

    }

    public function testSignUpFailureOnUsernameAlreadyExistent() {
        //$this->createRoles();



        $this->json('POST', '/api/sign-up', $this->validUserObject);

        $this->json('POST', '/api/sign-up', $this->getUserWithSameUsernameButDifferentEmail())->seeJson(["Message" => "User with this username already exists"])->assertResponseStatus(400);

    }

    public function testAuthentication() {
        //$this->createRoles();
        $signUpRes = $this->json('POST', '/api/sign-up', $this->validUserObject);


        $res = $this->json('POST', '/api/auth', $this->validUserObject)->response->getContent();

        $token = json_decode($res)->token;
        $this->assertMatchesRegularExpression('/[A-Za-z0-9]*\.[A-Za-z0-9]*\.[A-Za-z0-9]*/', $token);
        $this->assertResponseOk();
    }

    public function testAuthenticationFailureOnWrongEmail() {
        //$this->createRoles();
        $this->json('POST', '/api/sign-up', $this->validUserObject);
        $this->json('POST', '/api/auth', $this->userObjectWithInvalidEmail)->seeJson(["Message" => "Passed credentials are invalid"])->assertResponseStatus(400);
    }

    public function testAuthenticationFailureOnWrongPassword() {
        //$this->createRoles();
        $this->json('POST', '/api/sign-up', $this->validUserObject);
        $this->json('POST', '/api/auth', $this->userObjectWithInvalidPassword)->seeJson(["Message" => "Passed credentials are invalid"])->assertResponseStatus(400);
    }


    public function testAuthenticatedAccess() {
        //$this->createRoles();

        $this->json('POST', '/api/sign-up', $this->validUserObject);
        $res = $this->json('POST', '/api/auth', $this->validUserObject)->response->getContent();
        $token = json_decode($res)->token;


        $this->json('GET', '/api/get-resource-requiring-authentication', [], ['Authorization' => 'Bearer '.$token])->seeJson(['Message' => 'Access granted'])->assertResponseOk();

    }

    public function testAuthenticatedAccessFailureOnEmptyToken() {

        //$this->createRoles();
        $this->json('POST', '/api/sign-up', $this->validUserObject);

        $this->json('GET', '/api/get-resource-requiring-authentication', [])->seeJson(["Message"=>"Request is unauthorized: token is empty"])->assertResponseStatus(403);
    }

    // public function testAuthenticatedAccessFailureOnUnsupportedTokenFormat() {

    //     //$this->createRoles();
    //     $this->json('POST', '/api/sign-up', $this->validUserObject);
    //     $res = $this->json('POST', '/api/auth', $this->validUserObject)->response->getContent();
    //     $token = json_decode($res)->token;
    //     $token = $token.'unsupported';



    //     $this->json('GET', '/api/get-resource-requiring-authentication', ['Authorization' => 'Bearer '.$token])->seeJson(["Message"=>"Token is not valid"])->assertResponseStatus(400);
    // }

    // public function testAuthenticatedAccessFailureOnInvalidToken() {

    //     //$this->createRoles();
    //     $this->json('POST', '/api/sign-up', $this->validUserObject);
    //     $token = TokenService::generateToken('abc', 'abc');
    //     $token = str_replace('.', ':', $token);


    //     $this->json('GET', '/api/get-resource-requiring-authentication', ['Authorization' => 'Bearer '.$token])->seeJson(["Message"=>"Token is not valid"])->assertResponseStatus(400);
    // }


}
