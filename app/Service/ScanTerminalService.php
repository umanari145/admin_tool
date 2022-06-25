<?php

namespace App\Service;

use App\Models\ScanTerminal;
use Cache;
use App\Constant\ConfigConst;
use Exception;
use Log;
use DB;

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
            $terminals = ScanTerminal::getScanTerminalList($requestData);
            $res = [
                'data' => $terminals,
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
     * ターミナルの更新
     *
     * @param　array $requestData ターミナルのデータ
     * @return レスポンス
     */
    public function registScanTerminal(array $requestData): array
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        DB::beginTransaction();
        try {
            $scan_terminal = new ScanTerminal();
            $scan_terminal->fill($requestData);
            $scan_terminal->save();

            if (!$scan_terminal->id) {
                throw new Exception("登録が失敗ました。");
            }

            $scan_terminal_obj = ScanTerminal::find($scan_terminal->id);

            DB::commit();
            $res = [
                'data' => $scan_terminal_obj,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (Exception $e) {
            DB::rollback();
            Log::critical('RollBackを行いました。');
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
     * ターミナルデータの更新
     *
     * @param string $scan_terminal_id ターミナルID
     * @param array $data データ
     * @return レスポンス
     */
    public function updateScanTerminal(string $scan_terminal_id, array $data): array
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        DB::beginTransaction();
        try {
            $scan_terminal = ScanTerminal::find($scan_terminal_id);

            if (is_null($scan_terminal)) {
                throw new Exception(sprintf("存在しないハンディです。[id = %s]", $scan_terminal_id));
            }
            $scan_terminal->fill($data);
            $scan_terminal->save();

            $dbData = ScanTerminal::find($scan_terminal_id);

            $res = [
                'data' => $dbData,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::critical('RollBackを行いました。');
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
     * ターミナルの削除
     *
     * @param array $scan_terminal_ids 削除ID
     * @return レスポンス
     */
    public function deleteScanTerminal(array $scan_terminal_ids): array
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        DB::beginTransaction();
        try {
            $scan_terminals = ScanTerminal::whereIn('id', $scan_terminal_ids);

            if ($scan_terminals->count() === 0) {
                throw new Exception("ハンディが存在しません。");
            }

            $res = $scan_terminals->delete();

            if ($res !== count($scan_terminal_ids)) {
                throw new Exception("削除が失敗しました。IDの件数と削除の件数が一致しません。");
            }

            DB::commit();
            $res = [
                'data' => null,
                'result' => ConfigConst::SERVICE_SUCCESS
            ];
        } catch (Exception $e) {
            DB::rollback();
            Log::critical('RollBackを行いました。');
            Log::critical([$e->getMessage(), $e->getTraceAsString()]);

            $res = [
                'data' => null,
                'errorMessage' => $e->getMessage(),
                'result' => ConfigConst::SERVICE_ERROR
            ];
        }
        return $res;
    }
}
