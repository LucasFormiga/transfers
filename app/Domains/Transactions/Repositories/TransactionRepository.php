<?php

namespace App\Domains\Transactions\Repositories;

use Illuminate\Support\Facades\Http;

class TransactionRepository
{
    public function authorize(): bool
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        } catch (\Throwable $exception) {
            return false;
        }

        if ($response->successful()) {
            return $response['message'] == 'Autorizado';
        }

        return false;
    }

    public function notify(): bool
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        } catch (\Throwable $exception) {
            return false;
        }

        if ($response->successful()) {
            return $response['message'] == 'Enviado';
        }

        return false;
    }
}
