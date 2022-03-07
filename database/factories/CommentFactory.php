<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;




    public function definition(): array
    {
    	return [
           'user_id' => User::all()->random()->id,
           'title' => $this->faker->text(),
           'body'  => $this->faker->text()
    	];
    }
}
