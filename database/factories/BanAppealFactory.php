<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\BanAppeal;
use App\Models\User;

class BanAppealFactory extends Factory
{
    protected $model = BanAppeal::class;




    public function definition(): array
    {
    	return [
           'user_id' => User::all()->random()->id,
           'ban_appeal_message' => $this->faker->text()
    	];
    }
}
