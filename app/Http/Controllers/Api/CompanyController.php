<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Service\CompanyService;

class CompanyController extends ApiBasicController
{
    public function index(Request $request)
    {
        $scanTerminalService = new CompanyService();
        $res = $scanTerminalService->getCompanyList();

        return $this->retServiceResponse($res);
    }
}
