<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CsvField;
use App\Constant\ConfigConst;

class CsvFieldFactory extends Factory
{
    protected $model = CsvField::class;

    public function definition(): array
    {
        return [
            'csv_category' => ConfigConst::CSV_PRODUCT_MASTER_UPLOAD,
            'field_name' => 'attribute1_code',
            'field_disp_name' => '属性1コード',
            'is_required' => 0,
            'output_type' => 'NORMAL'
        ];
    }
}
