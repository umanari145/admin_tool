<?php

namespace App\Service;

use App\Model\Maddress;
use Cache;
use App\Constant\ConfigConst;

class CsvService
{

    public function getCscField(string $zip)
    {
        $res = [
            'result' => '',
            'data' => ''
        ];

        try {
            $res = [
                'data' => null,
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