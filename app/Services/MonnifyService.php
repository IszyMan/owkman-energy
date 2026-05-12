<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MonnifyService
{
    public function getToken()
    {
        $response = Http::withBasicAuth(
            env('MONNIFY_API_KEY'),
            env('MONNIFY_SECRET')
        )->post(env('MONNIFY_BASE').'/api/v1/auth/login');

        return $response['responseBody']['accessToken'];
    }

    public function initializePayment($data)
    {
        $token = $this->getToken();

        return Http::withToken($token)->post(
            env('MONNIFY_BASE').'/api/v1/merchant/transactions/init-transaction',
            $data
        )->json();
    }
}