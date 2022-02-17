<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    protected $model = UserInfo::class;

    public function definition(): array
    {
    	return [
    	    'full_name' => $this->faker->name(),
            'bio' => $this->faker->text(),
            'isBanned' => $this->faker->boolean(),
            'user_id' => User::factory()
    	];
    }
}
