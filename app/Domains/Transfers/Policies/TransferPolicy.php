<?php

namespace App\Domains\Transfers\Policies;

use App\Domains\Transfers\Models\Transfer;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    use HandlesAuthorization;

    public function store(User $user, $payer)
    {
        return $user->canTransfer() && $user->id == $payer;
    }

    public function destroy(User $user, Transfer $transfer)
    {
        return $transfer->payer == $user->id || $transfer->payee == $user->id;
    }
}
