<?php

use App\Models\ScanTerminal;
use Illuminate\Database\Seeder;

class ScanTerminalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ScanTerminalTableSeeder (seedingの実行　履歴に残らない)
     * @return void
     */
    public function run()
    {
        ScanTerminal::factory(100)->create();
    }
}
