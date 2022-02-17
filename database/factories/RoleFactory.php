<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

use App\Http\Service\TokenService;
use App\Models\Role;
use App\Models\User;

class RoleFactory extends Factory
{
    protected $model = Role::class;




    public function definition(): array
    {
    	return [
            'name' => ''
    	];
    }
}
