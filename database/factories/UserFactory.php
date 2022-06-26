<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'root user',
            'email' => '0000',
            'password' => '$2y$10$ZeGL47Z2nLEh42agvDiNy.6sIsVjRi.qFEmF7AW/B0Hkgd3CZbryy', // aaaa
            'remember_token' => Str::random(10),
        ];
    }
}
