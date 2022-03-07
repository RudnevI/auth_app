<?php

namespace Database\Factories;

use App\Model;
use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Service;
use App\Http\Service\TokenService;
use App\Models\User;

class TokenFactory extends Factory
{
    protected $model = Token::class;

    public function definition(): array
    {
    	return [
            'access_token' => TokenService::generateToken(uniqid(), uniqid()),
            'refresh_token' => null,
            'expiration_date' => TokenService::getExpirationDate(),
            'user_id'=>User::all()->random()->id
    	];
    }
}
