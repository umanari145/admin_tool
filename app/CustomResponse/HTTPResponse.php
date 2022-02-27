<?php

namespace App\CustomResponse;

/**
 * HTTPレスポンス
 */
class HTTPResponse
{
    public $httpStatusCode;

    public $data;

    public $errorMessage;

    public function __construct()
    {
        $httpStatusCode = null;
        $data = null;
        $errorMessage = null;
    }

    public function retResponse(): array
    {
        return [
            'http_status_code' => $this->httpStatusCode,
            'data' => $this->data,
            'errorMessage' => $this->errorMessage
        ];
    }
}