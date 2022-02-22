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

    }

    public function testTokenGenerationPatternMatch() {
        preg_match(TokenService::generateToken());
    }
}
