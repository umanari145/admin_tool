<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Model\CsvField;
use App\Constant\ConfigConst;
use Faker\Generator as Faker;

$factory->define(CsvField::class, function (Faker $faker) {
    return [
        'csv_category' => ConfigConst::CSV_PRODUCT_MASTER_UPLOAD,
        'field_name' => 'attribute1_code',
        'field_disp_name' => '属性1コード',
        'is_required' => 0,
        'output_type' => 'NORMAL'
    ];
});
