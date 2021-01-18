<?php

namespace Tests\Unit\Services;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Transactions\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private TransactionService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(TransactionService::class);
    }

    public function testItCanCreateAnTransaction()
    {
        $data = [
            'payer' => $this->user->id,
            'payee' => $this->seller->id,
            'value' => 100.00,
        ];

        $response = $this->service->store($data);

        $this->assertNotNull($response);
        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseHas('transactions', $data);
    }

    public function testItCanRevertAnTransaction()
    {
        $response = $this->service->destroy(
            $this->transaction
        );

        $this->assertNotNull($response);
        $this->assertEquals(true, (bool) $response);
        $this->assertSoftDeleted('transactions', [
            'id' => $this->transaction->id,
            'payer' => $this->transaction->payer,
            'payee' => $this->transaction->payee,
        ]);
    }
}
