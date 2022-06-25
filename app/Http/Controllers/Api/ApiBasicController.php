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

class ApiBasicController extends Controller
{

    protected function retValidResponse($validateResult)
    {
        $httpResponse = new HTTPResponse();
        $httpResponse->httpStatusCode = Response::HTTP_BAD_REQUEST;
        $errorMessage = $validateResult
            ->errors()
            ->toArray();

        $errorMessage2 =  array_map(function ($v) {
            return implode("\n", $v);
        }, $errorMessage);
        $httpResponse->errorMessage = $errorMessage2;

        return response()->json($httpResponse->retResponse(), $httpResponse->httpStatusCode, [], JSON_UNESCAPED_UNICODE);
    }

    protected function convertPaginateData(array &$res, $paginate_count = 10): void
    {
        $res['data'] = $res['data']->paginate($paginate_count)->toArray();
        foreach ($res['data'] as $k => $v) {
            if ($k === 'data') {
                $res['data'] = $v;
            } else {
                $res['meta'][$k] = $v;
            }
        }
    }

    protected function retServiceResponse(array $res)
    {
        $httpResponse = new HTTPResponse();
        if ($res['result'] === ConfigConst::SERVICE_SUCCESS) {
            $httpResponse->httpStatusCode = Response::HTTP_OK;
            $httpResponse->data = $res['data'];
            if (isset($res['meta'])) {
                $httpResponse->meta = $res['meta'];
            }
        } else {
            $httpResponse->httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $httpResponse->errorMessage = $res['errorMessage'];
        }

        return response()->json(
            $httpResponse->retResponse(),
            $httpResponse->httpStatusCode,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
