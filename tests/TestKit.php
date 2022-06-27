<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        //$response = Http::withHeaders($this->getHeaders())
        //    ->post('http://nginx/api/login', $data);
        //$retJson =  $response->json();
        // CIで使えないためボツ

        $token = auth('api')->attempt($data);

        if (!empty($token)) {
            return $token;
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
