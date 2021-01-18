<?php

namespace App\Domains\Transactions\Policies;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function store(User $user, $payer)
    {
        return $user->canTransfer() && $user->id == $payer;
    }

    public function destroy(User $user, Transaction $transfer)
    {
        return $transfer->payer == $user->id || $transfer->payee == $user->id;
    }
}
