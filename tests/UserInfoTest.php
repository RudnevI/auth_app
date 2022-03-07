<?php

use App\Models\Token;
use App\Models\User;
use App\Models\UserInfo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserInfoTest extends BaseCRUD_Test
{
   protected $model = UserInfo::class;
   protected $rootRegistry = ['getAll' => 'user-info', 'getOneById' => 'getUserInfoById', 'create' => 'user-info', 'deleteOneById' => '', 'updateOneById'];



   public function testCreate() {
   $user = User::factory()->create();
   $user->save();

    $userInfoObject = ['full_name' => 'reghweailgkfjeawfklgahg', 'email' => $user->email, 'bio' => 'test bio'];
    $res = $this->json('POST', '/api/user-info',$userInfoObject);
    $this->assertResponseStatus(201);
    $this->assertJson(json_encode($res));

   }

   public function testUpdate() {

    $userId = UserInfo::all()->random()->user_id;
    $email = User::where('id', $userId)->first()->email;


    $userInfoObject = ['full_name' => 'test666', 'email' => $email, 'bio' => 'test bio'];
    $res = $this->json('PUT', '/api/user-info',$userInfoObject);
    $this->assertResponseOk();
    $this->assertJson(json_encode(['Message' => 'UPDATED']), $res->response->getContent());
   }
}
