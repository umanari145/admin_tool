<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ScanTerminalService;
use App\Form\FormValid;
use Validator;

class ScanTerminalController extends ApiBasicController
{

    public function index(Request $request)
    {
        $formValid = new FormValid('scan_terminal/index.yaml');
        $requestData = $request->all();

        $validateResult =  Validator::make($requestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->getScanTerminalList($requestData);

        return $this->retServiceResponse($res);
    }
/*
    public function create(string $csvCategory, Request $request)
    {
        $requestData = $request->all();
        $formValid = new FormValid('csv_category_regist.yaml');

        $csvCategory = (int)$csvCategory;

        if (empty($requestData)) {
            $httpResponse = new HTTPResponse();
            $httpResponse->httpStatusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = 'データが入力されていません。';
            $httpResponse->errorMessage = $errorMessage;
            return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
        }

        foreach ($requestData as $eachData) {
            $eachData2 = array_merge(['csv_category' => $csvCategory], $eachData);
            $validateResult =  Validator::make($eachData2, $formValid->getValidRule());
            if ($validateResult->fails()) {
                return $this->retValidResponse($validateResult);
            }
        }

        $csvService = new CsvService();
        $res = $csvService->registCsvField($csvCategory, $requestData);

        return $this->retServiceResponse($res);
    }


    public function update(string $id, Request $request)
    {
        $requestData = $request->all();

        $httpResponse = new HTTPResponse();
        $formValid = new FormValid('csv_field.yaml');
        $validateResult =  Validator::make($requestData['updateData'], $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $csvService = new CsvService();
        $res = $csvService->updateCsvField($id, $requestData['updateData']);

        return $this->retServiceResponse($res);
    }

    public function delete(Request $request)
    {
        $requestData = $request->all();
        $httpResponse = new HTTPResponse();
        $formValid = new FormValid('csv_field_delete.yaml');
        $validateResult =  Validator::make($requestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $csvService = new CsvService();
        $res = $csvService->deleteCsvField($requestData['delete_ids']);

        return $this->retServiceResponse($res);
    }*/
}
