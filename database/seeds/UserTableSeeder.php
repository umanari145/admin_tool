<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=UserTableSeeder (seedingの実行　履歴に残らない)
     * @return void
     */
    public function run()
    {
        User::factory()->create();
    }
}
