<?php

namespace Tests;

use Illuminate\Support\Facades\Http;

class TestKit
{
    public function getHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function getToken(string $userId = '0000', string $password = 'aaaa'): string
    {
        $data = [
            'email' => $userId,
            'password' => $password
        ];

        // 80番ポートはnginxなので以下のようなAPIを叩くことになる
        $response = Http::withHeaders($this->getHeaders())
            ->post('http://nginx/api/login', $data);

        $retJson =  $response->json();
        if (!empty($retJson['access_token'])) {
            return $retJson['access_token'];
        } else {
            return null;
        }
    }

    public function getHeadersIncToken(string $access_token): array
    {
        $headers = $this->getHeaders();
        $headers['Authorization'] = 'Bearer ' . $access_token;
        return $headers;
    }
}
