<?php

use App\Http\Service\CrudService;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserInfo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseCRUD_Test extends TestCase
{
   protected $model;

   private $urlPrefix = '/api/';

   protected $rootRegistry = ['getAll' => '', 'getOneById' => '', 'create' => '', 'deleteOneById' => '', 'updateOneById'];





   public function testCreate() {


       $this->json('POST', $this->urlPrefix.$this->rootRegistry['create'], $this->model::factory()->make()->toArray())->seeJson(['Message' => 'CREATED'])->assertResponseStatus(201);
   }

   public function testGetAll() {
         $this->json('GET', $this->urlPrefix.$this->rootRegistry['getAll'])->assertResponseOk();

   }

   public function testGetOneById() {

        $id = $this->createEntityIfNotExists()->id;

        $this->json('GET', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id)->assertResponseOk();
   }

   public function testUpdateById() {
        $id = $this->model::all()->random()->id;

        if($this->model === UserInfo::class) {
            $userInfo = $this->model::factory()->make();

            $userInfoArray = $this->convertFalseToIntegerInArrayCast($userInfo, 'isBanned');

            $this->json('PUT', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id, $userInfoArray)->assertResponseOk();


        }

        $this->json('PUT', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id, $this->model::factory()->make()->toArray())->assertResponseOk();
   }

   public function deleteById() {
        $id = $this->model::all()->first()->id;
        $this->json('DELETE', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id)->assertResponseStatus(201);
   }

   public function testFailureOnNotExists() {

    $entity = $this->model::all()->random();
    $id = $entity->id;
    $entity->delete();
    $this->json('GET', $this->urlPrefix.$this->rootRegistry['getAll'].'/'.$id)->seeJson(["Message" => "Not found"])->assertResponseStatus(404);

   }



   private function createEntityIfNotExists() {
       if($this->model::all()->count() === 0) {
           return $this->model::factory()->create();
       }
       return $this->model::all()->random();
   }

   private function convertFalseToIntegerInArrayCast($object, $booleanElementName) {

            $result = $object[$booleanElementName] ? 1 : 0;

        $array = $object->toArray();
        $array[$booleanElementName] = $result;

        return $array;
   }

   public function testGetAllService() {
       $this->assertIsArray(CrudService::getAll($this->model)->toArray());
   }

   public function testGetOneByIdService() {
       $id = $this->createEntityIfNotExists()->id;
       $this->assertNotNull(CrudService::getById($this->model, $id));
   }

   public function testFailureOnNotExistsService() {
       $entity = $this->model::all()->random();
       $id = $entity->id;
       $entity->delete();
       $this->expectException(NotFoundHttpException::class);
        CrudService::getById($this->model, $id);
   }

   public function testUpdateByIdService() {
        $id = $this->createEntityIfNotExists()->id;
        $this->assertNotNull(CrudService::updateById($this->model, $this->model::factory()->create()->toArray(), $id));

   }

   public function testDeleteByIdService() {
    $id = $this->createEntityIfNotExists()->id;
    $this->assertTrue(CrudService::deleteById($this->model,$id));
   }






}
