<?php

namespace App\Domains\Transactions\Observers;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Transactions\Repositories\TransactionRepository;

class TransactionObserver
{
    public function created(Transaction $transfer)
    {
        $payerWallet = $transfer->sender->wallet()->first();
        $payeeWallet = $transfer->receiver->wallet()->first();

        $payerWallet->update([
            'balance' => ($payerWallet->value - $transfer->value),
        ]);

        $payeeWallet->update([
            'balance' => ($payerWallet->value + $transfer->value),
        ]);

        app(TransactionRepository::class)->notify();
    }

    public function deleted(Transaction $transfer)
    {
        $payerWallet = $transfer->sender->wallet()->first();
        $payeeWallet = $transfer->receiver->wallet()->first();

        $payerWallet->update([
            'balance' => ($payerWallet->value + $transfer->value),
        ]);

        $payeeWallet->update([
            'balance' => ($payerWallet->value - $transfer->value),
        ]);
    }
}
