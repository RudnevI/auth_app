<?php

use App\Models\Comment;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CommentTest extends BaseCRUD_Test
{
    /**
     * A basic test example.
     *
     * @return void
     */

     protected $model = Comment::class;
     protected $rootRegistry = ['getAll' => 'comments', 'getOneById' => 'comments/{id}', 'create' => 'comments', 'deleteOneById' => 'comments/{id}', 'updateOneById/{id}'];

}
