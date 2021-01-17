<?php

namespace App\Domains\Transfers\Repositories;

use Illuminate\Support\Facades\Http;

class TransferRepository
{
    public function authorize()
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        if ($response->successful()) {
            return $response['message'] == 'Autorizado';
        }

        return false;
    }
}
