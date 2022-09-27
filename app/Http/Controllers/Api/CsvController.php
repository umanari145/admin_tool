<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Service\CsvService;
use App\CustomResponse\HTTPResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormValid;
use Validator;

class CsvController extends ApiBasicController
{
    public function show(string $csvCategory)
    {
        $formValid = new FormValid('csv_category.yaml');
        $validateResult =  Validator::make([
            'csv_category' => $csvCategory
        ], $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $csvService = new CsvService();
        $res = $csvService->getCsvFieldList($csvCategory);

        return $this->retServiceResponse($res);
    }

    public function store(string $csvCategory, Request $request)
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
    }
}