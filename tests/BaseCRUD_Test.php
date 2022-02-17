<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

abstract class BaseCRUD_Test extends TestCase
{
   protected $model;

   private $urlPrefix = '/api/';

   protected $rootRegistry = ['getAll' => '', 'getOneById' => '', 'create' => '', 'deleteOneById' => '', 'updateOneById'];





   public function testCreate() {

       $this->json('POST', $this->urlPrefix.$this->rootRegistry['create'], $this->model::factory()->make()->toArray())->seeJson(['Message' => 'CREATED'])->assertResponseStatus(201);
   }

   public function testGetAll() {
        $this->json('GET', $this->urlPrefix.$this->rootRegistry['getAll'])->assertResponseStatus(200);
   }

   public function testGetOneById() {

        $id = $this->model::all()->first()->id;
        $this->json('GET', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id)->assertResponseOk();
   }

   public function testUpdateById() {
        $id = $this->model::all()->first()->id;
        $this->json('PUT', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id, $this->model::factory()->make()->toArray())->assertResponseOk();
   }

   public function deleteById() {
        $id = $this->model::all()->first()->id;
        $this->json('DELETE', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id)->assertResponseStatus(201);
   }









}
