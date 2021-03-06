<?php

namespace Tests;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;
    protected $seller;
    protected $transaction;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            $namespace = 'Database\\Factories\\';

            $modelName = Str::afterLast($modelName, '\\');

            return "{$namespace}{$modelName}Factory";
        });

        $this->user = User::factory()->create();
        $this->seller = User::factory()->seller()->create();
        $this->transaction = Transaction::create([
            'payer' => $this->user->id,
            'payee' => $this->user->id,
            'value' => 100.00,
        ]);
    }
}
