<?php

use App\Models\BanAppeal;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BanAppealTest extends BaseCRUD_Test
{
    protected $model = BanAppeal::class;
    protected $rootRegistry = ['getAll' => 'ban-appeals', 'getOneById' => 'ban-appeals/{id}', 'create' => 'ban-appeals', 'deleteOneById' => 'ban-appeals/{id}', 'updateOneById/{id}'];
}
