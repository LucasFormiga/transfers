<?php

namespace App\Domains\Transactions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer' => 'required|uuid|exists:users,id',
            'payee' => 'required|uuid|exists:users,id',
            'value' => 'required|numeric',
        ];
    }
}
