<?php

use App\Models\Token;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TokenTest extends BaseCRUD_Test
{
   protected $model = Token::class;
   protected $rootRegistry = ['getAll' => 'tokens', 'getOneById' => '', 'create' => 'tokens', 'deleteOneById' => '', 'updateOneById'];
}
