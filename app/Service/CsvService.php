<?php

namespace App\Service;

use App\Model\CsvField;
use Cache;
use App\Constant\ConfigConst;

class CsvService
{

    /**
     * CSVリストの取得
     *
     * @param string $csvCategory CSVカテゴリー
     * @return レスポンス
     */
    public function getCsvFieldList(string $csvCategory)
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        try {
            $csvFieldData = CsvField::getCsvFieldData($csvCategory);

            $res = [
                'data' => $csvFieldData,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];

        } catch (\Exception $e) {
            \Log::critical([$e->getMessage(), $e->getTraceAsString()]);

            $res = [
                'data' => null,
                'errorMessage' => $e->getMessage(),
                'result' => ConfigConst::SERVICE_ERROR
            ];
        }
        return $res;
    }

    /**
     * CSVデータの更新
     *
     * @param string $csvCategory CSVカテゴリー
     * @param array $data データ
     * @return レスポンス
     */
    public function updateCsvField(string $id, array $data)
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        try {
            $dbRes = CsvField::where('id', $id)
                ->update($data);

            $dbData = CsvField::find($id);

            $res = [
                'data' => $dbData,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (\Exception $e) {
            \Log::critical([$e->getMessage(), $e->getTraceAsString()]);

            $res = [
                'data' => null,
                'errorMessage' => $e->getMessage(),
                'result' => ConfigConst::SERVICE_ERROR
            ];
        }
        return $res;
    }
}