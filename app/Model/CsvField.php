<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class CsvField extends Model
{
    protected $table = 'csv_field';

    // timestampの自動更新をfalseにする
    public $timestamps = false;

    protected $fillable = [
        'field_name',
        'field_disp_name',
        'is_required'
    ];

    /**
     * @param string $csv_category CSVカテゴリー
     * @return CSVリスト
     */
    public static function getCsvFieldData(string $csvCategory)
    {
        $csvList = self::select('id', 'field_name', 'field_disp_name', 'is_required', 'output_type', 'param')
            ->where('csv_category', $csvCategory)
            ->get();

        return $csvList;
    }

}