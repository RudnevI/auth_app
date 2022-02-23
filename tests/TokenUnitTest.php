<?php

use App\Http\Service\TokenService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use function PHPSTORM_META\type;

class TokenUnitTest extends TestCase
{

    public function testMatchToken() {
        $this->assertTrue(TokenService::doesTokenMatchThePattern('hH1.hH1.hH1') > 0);
    }

    public function testMatchTokenFailure() {
        $this->assertTrue(TokenService::doesTokenMatchThePattern('incorrect.data') == 0);
    }

    public function testTokenSignatureValidityCheck() {
        $expectedSignature = hash_hmac('sha256', 'test.test', env('JWT_SECRET'));
        $actualSignature = explode('.',TokenService::generateToken('test', 'test'))[2];
        $this->assertEquals($actualSignature, $expectedSignature);
    }

    public function testTokenGenerationPatternMatch() {
        $this->assertTrue(preg_match(TokenService::$tokenPattern, TokenService::generateToken('test', 'test')) === 1);
    }
}
