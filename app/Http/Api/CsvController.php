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

class CsvController extends Controller
{
    public function getCsvField(string $csvCategory)
    {
        $httpResponse = new HTTPResponse();
        $formValid = new FormValid('csv_category.yaml');
        $validateResult =  Validator::make([
            'csv_category' => $csvCategory
        ], $formValid->getValidRule());

        if ($validateResult->fails()) {
            $httpResponse->httpStatusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = $validateResult
                ->errors()
                ->toArray();

            $errorMessage2 =  array_map(function ($v) {
                return implode("\n", $v);
            }, $errorMessage);
            $httpResponse->errorMessage = $errorMessage;
            return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
        }

        $csvService = new CsvService();
        $res = $csvService->getCsvFieldList($csvCategory);

        if ($res['result'] === ConfigConst::SERVICE_SUCCESS) {
            $httpResponse->httpStatusCode = Response::HTTP_OK;
            $httpResponse->data = $res['data'];
        } else {
            $httpResponse->httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $httpResponse->errorMessage = $res['errorMessage'];
        }

        return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
    }


    public function updateCsvField(string $id, Request $request)
    {
        $requestData = $request->all();

        $httpResponse = new HTTPResponse();
        $formValid = new FormValid('csv_field.yaml');
        $validateResult =  Validator::make($requestData['updateData'], $formValid->getValidRule());

        if ($validateResult->fails()) {
            $httpResponse->httpStatusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = $validateResult
                ->errors()
                ->toArray();

            $errorMessage2 =  array_map(function ($v) {
                return implode("\n", $v);
            }, $errorMessage);
            $httpResponse->errorMessage = $errorMessage;
            return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
        }

        $csvService = new CsvService();
        $res = $csvService->updateCsvField($id, $requestData['updateData']);

        if ($res['result'] === ConfigConst::SERVICE_SUCCESS) {
            $httpResponse->httpStatusCode = Response::HTTP_OK;
            $httpResponse->data = $res['data'];
        } else {
            $httpResponse->httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $httpResponse->errorMessage = $res['errorMessage'];
        }

        return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
    }

    public function deleteCsvField(Request $request)
    {
        $requestData = $request->all();
        $httpResponse = new HTTPResponse();
        $formValid = new FormValid('csv_field_delete.yaml');
        $validateResult =  Validator::make($requestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            $httpResponse->httpStatusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = $validateResult
                ->errors()
                ->toArray();

            $errorMessage2 =  array_map(function ($v) {
                return implode("\n", $v);
            }, $errorMessage);
            $httpResponse->errorMessage = $errorMessage;
            return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
        }

        $csvService = new CsvService();
        $res = $csvService->deleteCsvField($requestData['delete_ids']);

        if ($res['result'] === ConfigConst::SERVICE_SUCCESS) {
            $httpResponse->httpStatusCode = Response::HTTP_OK;
            $httpResponse->data = $res['data'];
        } else {
            $httpResponse->httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $httpResponse->errorMessage = $res['errorMessage'];
        }

        return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
    }
}