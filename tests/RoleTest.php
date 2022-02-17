<?php

use App\Models\Role;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RoleTest extends BaseCRUD_Test
{
   protected $model = Role::class;
   protected $rootRegistry = ['getAll' => 'roles', 'getOneById' => 'roles/{id}', 'create' => 'roles', 'deleteOneById' => 'roles/{id}', 'updateOneById/{id}'];
}
