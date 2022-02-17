<?php


use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends BaseCRUD_Test
{
   protected $model = User::class;
   protected $rootRegistry = ['getAll' => 'users', 'getOneById' => '', 'create' => 'users', 'deleteOneById' => '', 'updateOneById'];
}
