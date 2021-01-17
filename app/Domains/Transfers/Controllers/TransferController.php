<?php

namespace App\Domains\Transfers\Controllers;

use App\Domains\Transfers\Models\Transfer;
use App\Domains\Transfers\Requests\CreateTransferRequest;
use App\Domains\Transfers\Services\TransferService;
use App\Domains\Users\Models\User;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class TransferController extends Controller
{
    private TransferService $service;

    public function __construct(TransferService $service)
    {
        $this->service = $service;
    }

    public function store(CreateTransferRequest $request)
    {
        $this->authorize('transfer-allowed', $request->get('payer'));

        return response()->json([
            'success' => $this->service->store($request->validated()),
        ], Response::HTTP_CREATED);
    }

    public function destroy(User $user, Transfer $transfer)
    {
        $this->authorize('transfer-revert-allowed', $transfer);

        return response()->json([
            'success' => $this->service->destroy($transfer),
        ], Response::HTTP_OK);
    }
}
