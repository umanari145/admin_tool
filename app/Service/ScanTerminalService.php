<?php

namespace App\Service;

use App\Models\ScanTerminal;
use Cache;
use App\Constant\ConfigConst;
use Exception;
use Log;

class ScanTerminalService
{
    /**
     * ターミナルリストの取得
     *
     * @param array $requestData リクエストパラメーター
     * @return array レスポンス
     */
    public function getScanTerminalList(array $requestData = null): array
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        try {
            $csvFieldData = ScanTerminal::getScanTerminalList($requestData);

            $res = [
                'data' => $csvFieldData,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (Exception $e) {
            Log::critical([$e->getMessage(), $e->getTraceAsString()]);

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
    /*public function updateCsvField(string $id, array $data)
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
    }*/

    /**
     * CSVデータの削除
     *
     * @param array $deleteIds 削除ID
     * @return レスポンス
     */
    /*public function deleteCsvField(array $deleteIds)
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        \DB::beginTransaction();
        try {

            $res = CsvField::whereIn('id', $deleteIds)
                ->delete();

            if ($res !== count($deleteIds)) {
                throw new \Exception("削除が失敗ました。IDの件数と削除の件数が一致しません。");
            }

            \DB::commit();
            $res = [
                'data' => null,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::critical('RollBackを行いました。');
            \Log::critical([$e->getMessage(), $e->getTraceAsString()]);

            $res = [
                'data' => null,
                'errorMessage' => $e->getMessage(),
                'result' => ConfigConst::SERVICE_ERROR
            ];
        }
        return $res;
    }*/

    /**
     * CSVフィールドの更新
     *
     * @param int $csvCategory CSVカテゴリー
     * @param　array $requestData CSVFieldData
     * @return レスポンス
     */
    /*public function registCsvField(int $csvCategory, array $updateData)
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        \DB::beginTransaction();
        try {

            $csvField = array_map(function ($v) use ($csvCategory) {
                $v['csv_category'] = $csvCategory;
                return $v;
            }, $updateData);

            $res = CsvField::insert($csvField);

            if (!$res) {
                throw new \Exception("登録が失敗ました。登録件数が入力の件数が一致しません。");
            }

            \DB::commit();
            $res = [
                'data' => null,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::critical('RollBackを行いました。');
            \Log::critical([$e->getMessage(), $e->getTraceAsString()]);

            $res = [
                'data' => null,
                'errorMessage' => $e->getMessage(),
                'result' => ConfigConst::SERVICE_ERROR
            ];
        }
        return $res;
    }*/
}
