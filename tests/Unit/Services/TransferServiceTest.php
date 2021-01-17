<?php

namespace Tests\Unit\Services;

use App\Domains\Transfers\Models\Transfer;
use App\Domains\Transfers\Services\TransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private TransferService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(TransferService::class);
    }

    public function testItCanCreateAnTransfer()
    {
        $data = [
            'payer' => $this->user->id,
            'payee' => $this->seller->id,
            'value' => 100.00,
        ];

        $response = $this->service->store($data);

        $this->assertNotNull($response);
        $this->assertInstanceOf(Transfer::class, $response);
        $this->assertDatabaseHas('transfers', $data);
    }

    public function testItCanRevertAnTransfer()
    {
        $response = $this->service->destroy(
            $this->transfer
        );

        $this->assertNotNull($response);
        $this->assertEquals(true, (bool) $response);
        $this->assertSoftDeleted('transfers', [
            'id' => $this->transfer->id,
            'payer' => $this->transfer->payer,
            'payee' => $this->transfer->payee,
        ]);
    }
}
