<?php

namespace Tests\Unit\Repositories;

use App\Domains\Transactions\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testTransactionAuthorizeMethodReturnsBoolean()
    {
        $repository = app(TransactionRepository::class);

        $this->assertIsBool($repository->authorize());
    }

    public function testTransactionNotifyMethodReturnsBoolean()
    {
        $repository = app(TransactionRepository::class);

        $this->assertIsBool($repository->authorize());
    }
}
