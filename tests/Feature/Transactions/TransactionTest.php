<?php

namespace Tests\Feature\Transactions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItCanCreateAnTransaction()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'payer' => $this->user->id,
            'payee' => $this->seller->id,
            'value' => 100.00,
        ];

        $response = $this->postJson(route('transaction.send'), $data);

        $response->assertCreated();

        $data = $response->json('success');

        $this->assertNotNull($response);
        $this->assertNotNull($data);
        $this->assertDatabaseHas('transactions', [
            'id' => $data['id'],
            'payer' => $data['payer'],
            'payee' => $data['payee'],
            'value' => $data['value'],
        ]);
    }

    public function testItCanRevertAnTransaction()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson(route('transaction.revert',
            [
                'user' => $this->user,
                'transaction' => $this->transaction
            ]
        ));

        $response->assertOk();

        $this->assertTrue(
            $response->json('success')
        );

        $this->assertSoftDeleted('transactions', [
            'id' => $this->transaction->id,
            'payer' => $this->transaction->payer,
            'payee' => $this->transaction->payee,
            'value' => $this->transaction->value,
        ]);
    }
}
