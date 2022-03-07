<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CsvService;
use App\CustomResponse\HTTPResponse;
use App\Constant\ConfigConst;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormValid;
use Validator;

class CsvController extends ApiBasicController
{
    public function getCsvField(string $csvCategory)
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


    public function updateCsvField(string $id, Request $request)
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

    public function deleteCsvField(Request $request)
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