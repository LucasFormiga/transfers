<?php

namespace Tests\Unit\Models;

use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionModelTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItReturnsAUserInstanceBySenderRelationship()
    {
        $transaction = $this->transaction;
        $relationship = $transaction->sender();
        $user = $relationship->first();

        $this->assertInstanceOf(BelongsTo::class, $relationship);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testItReturnsAUserInstanceByReceiverRelationship()
    {
        $transaction = $this->transaction;
        $relationship = $transaction->receiver();
        $user = $relationship->first();

        $this->assertInstanceOf(BelongsTo::class, $relationship);
        $this->assertInstanceOf(User::class, $user);
    }
}
