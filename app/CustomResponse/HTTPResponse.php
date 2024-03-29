<?php

namespace App\CustomResponse;

/**
 * HTTPレスポンス
 */
class HTTPResponse
{
    public $httpStatusCode;

    public $data;

    public $meta;

    public $errorMessage;

    public function __construct()
    {
        $this->httpStatusCode = null;
        $this->data = null;
        $this->errorMessage = null;
        $this->meta = null;
    }

    public function retResponse(): array
    {
        return [
            'http_status_code' => $this->httpStatusCode,
            'data' => $this->data,
            'meta' => $this->meta,
            'errorMessage' => $this->errorMessage
        ];
    }
}