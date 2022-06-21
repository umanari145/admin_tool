<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\ScanTerminal;

class ScanTerminalFactory extends Factory
{
    protected $model = ScanTerminal::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::factory(), //←ここ追記
            'mac_address' => $this->faker->macAddress(),
            'name' => $this->faker->word(),
            'meta_deleted' => 0
        ];
    }
}
