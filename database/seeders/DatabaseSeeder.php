<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     private $modelRegistry = [User::class, Token::class, UserInfo::class];
    public function run()
    {
        // $this->call('UsersTableSeeder');

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        foreach($this->modelRegistry as $model) {
            $model::factory()->count(10)->create();
        }




    }
}
