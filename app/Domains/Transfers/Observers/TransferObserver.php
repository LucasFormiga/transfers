<?php

namespace App\Domains\Transfers\Observers;

use App\Domains\Transfers\Models\Transfer;

class TransferObserver
{
    public function created(Transfer $transfer)
    {
        $payerWallet = $transfer->sender->wallet()->first();
        $payeeWallet = $transfer->receiver->wallet()->first();

        $payerWallet->update([
            'balance' => ($payerWallet->value - $transfer->value),
        ]);

        $payeeWallet->update([
            'balance' => ($payerWallet->value + $transfer->value),
        ]);
    }

    public function deleted(Transfer $transfer)
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
