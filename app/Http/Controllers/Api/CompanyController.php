<?php

namespace App\Http\Controllers\Api;

use App\CustomUtil\CustomEncrypter;
use Illuminate\Http\Request;
use App\Service\CompanyService;
use Log;

class CompanyController extends ApiBasicController
{

    public function __construct(CustomEncrypter $custom_encrypter)
    {
        //DIのテスト(他で使う箇所がないのでここで使ってます。別にencrypt処理を噛ませている場所はないです。)
        $this->custom_encrypter = $custom_encrypter;
        $encrypted = $this->custom_encrypter->encrypt('hello world');
        Log::info("encrypt test" . $encrypted);
    }

    public function index(Request $request)
    {
        $scanTerminalService = new CompanyService();
        $res = $scanTerminalService->getCompanyList();

        return $this->retServiceResponse($res);
    }
}
