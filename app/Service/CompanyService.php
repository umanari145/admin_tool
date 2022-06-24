<?php

namespace App\Service;

use App\Models\ScanTerminal;
use App\Models\Company;
use Cache;
use App\Constant\ConfigConst;
use Exception;
use Log;
use DB;

class CompanyService
{
    /**
     * 会社情報の取得
     *
     * @param array $requestData リクエストパラメーター
     * @return array レスポンス
     */
    public function getCompanyList(array $requestData = null): array
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        try {
            $companies = [];
            if (!Cache::store('file')->has('company_list')) {
                $companyData = Company::all()->map(function ($v) use (&$companies) {
                    $companies[$v->id] = $v->company_name;
                });
                Cache::store('file')->put('company_list', json_encode($companies), 60);
            } else {
                $companies_json = Cache::store('file')->get('company_list');
                $companies = json_decode($companies_json, true);
            }

            $res = [
                'data' => $companies,
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
}
