<?php

namespace App\Domains\Transactions\Services;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Transactions\Repositories\TransactionRepository;

class TransactionService
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $data): ?Transaction
    {
        return $this->repository->authorize()
            ? Transaction::create($data)
            : null;
    }

    public function destroy(Transaction $transfer): bool
    {
        return (bool) $transfer->delete();
    }
}
