<?php

namespace App\Domains\Transactions\Controllers;

use App\Domains\Transactions\Models\Transaction;
use App\Domains\Transactions\Requests\CreateTransactionRequest;
use App\Domains\Transactions\Services\TransactionService;
use App\Domains\Users\Models\User;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function store(CreateTransactionRequest $request)
    {
        $this->authorize('transaction-allowed', $request->get('payer'));

        return response()->json([
            'success' => $this->service->store($request->validated()),
        ], Response::HTTP_CREATED);
    }

    public function destroy(User $user, Transaction $transaction)
    {
        $this->authorize('transaction-revert-allowed', $transaction);

        return response()->json([
            'success' => $this->service->destroy($transaction),
        ], Response::HTTP_OK);
    }
}
