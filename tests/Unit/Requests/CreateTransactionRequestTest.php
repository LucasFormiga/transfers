<?php

namespace Tests\Unit\Requests;

use App\Domains\Transactions\Requests\CreateTransactionRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTransactionRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testItReturnsTheSameCreateTransactionRequestRules()
    {
        $request = new CreateTransactionRequest();

        $this->assertIsArray($request->rules());

        $this->assertEquals([
            'payer' => 'required|uuid|exists:users,id',
            'payee' => 'required|uuid|exists:users,id',
            'value' => 'required|numeric',
        ], $request->rules());
    }
}
