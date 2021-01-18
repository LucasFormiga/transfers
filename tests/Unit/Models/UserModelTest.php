<?php

namespace Tests\Unit\Models;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Users\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItReturnsAWalletInstance()
    {
        $user = $this->user;
        $relationship = $user->wallet();
        $wallet = $relationship->first();

        $this->assertInstanceOf(HasOne::class, $relationship);
        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testItReturnsATransactionInstanceByPayerRelationship()
    {
        $user = $this->user;
        $relationship = $user->payer();
        $payer = $relationship->first();

        $this->assertInstanceOf(HasMany::class, $relationship);
        $this->assertInstanceOf(Transaction::class, $payer);
    }

    public function testItReturnsATransactionInstanceByPayeeRelationship()
    {
        $user = $this->user;
        $relationship = $user->payee();
        $payee = $relationship->first();

        $this->assertInstanceOf(HasMany::class, $relationship);
        $this->assertInstanceOf(Transaction::class, $payee);
    }
}
