<?php

namespace Tests\Feature\Transfers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItCanCreateAnTransfer()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'payer' => $this->user->id,
            'payee' => $this->seller->id,
            'value' => 100.00,
        ];

        $response = $this->postJson(route('transfer.send'), $data);

        $response->assertCreated();

        $data = $response->json('success');

        $this->assertNotNull($response);
        $this->assertNotNull($data);
        $this->assertDatabaseHas('transfers', [
            'id' => $data['id'],
            'payer' => $data['payer'],
            'payee' => $data['payee'],
            'value' => $data['value'],
        ]);
    }

    public function testItCanRevertAnTransfer()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson(route('transfer.revert',
            [
                'user' => $this->user,
                'transfer' => $this->transfer
            ]
        ));

        $response->assertOk();

        $this->assertTrue(
            $response->json('success')
        );

        $this->assertSoftDeleted('transfers', [
            'id' => $this->transfer->id,
            'payer' => $this->transfer->payer,
            'payee' => $this->transfer->payee,
            'value' => $this->transfer->value,
        ]);
    }
}
