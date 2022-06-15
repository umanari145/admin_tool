<?php

use Illuminate\Database\Seeder;

class CsvFieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=CsvFieldTableSeeder (seedingの実行　履歴に残らない)
     * @return void
     */
    public function run()
    {
        $csvFilePath = sprintf("%s/database/seeds/%s", base_path(), "csv_field.csv");
        $fp = fopen($csvFilePath, "r");
        $count = 0;
        $dataList = [];
        while ($line = fgetcsv($fp, null, "\t")) {
            $count++;
            $data = [
                'csv_category' => sprintf("%07d", $line[0]),
                'field_name' => $line[1],
                'field_disp_name' => $line[2],
                'is_required' => (!empty($line[3]) ? 1 : 0),
                'output_type' => $line[4],
                'param' => ($line[5] == "NULL") ? null : $line[5],
                'meta_deleted' => 0,
            ];
            $dataList[] = $data;
            if ($count % 1000 === 0) {
                //echo $count . "\n";
                DB::table('csv_field')->insert($dataList);
                $dataList = [];
            }
        }
        DB::table('csv_field')->insert($dataList);
    }
}