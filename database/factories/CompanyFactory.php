<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'company_code' => $this->faker->companySuffix(),
            'company_name' => $this->faker->company(),
            'user_id' => 1,
            'plan_type' => 'standard',
            'register_ymd' => $this->faker->date(),
            'invitor_name' => '山本'
        ];
    }
}
