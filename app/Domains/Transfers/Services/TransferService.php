<?php

namespace App\Domains\Transfers\Services;

use App\Domains\Transfers\Models\Transfer;
use App\Domains\Transfers\Repositories\TransferRepository;

class TransferService
{
    private TransferRepository $repository;

    public function __construct(TransferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $data): ?Transfer
    {
        return $this->repository->authorize()
            ? Transfer::create($data)
            : null;
    }

    public function destroy(Transfer $transfer): bool
    {
        return (bool) $transfer->delete();
    }
}
