<?php

namespace App\Domains\Users\Controllers;

use App\Domains\Users\Models\User;
use App\Domains\Users\Requests\CreateUserRequest;
use App\Domains\Users\Requests\UpdateUserRequest;
use App\Domains\Users\Services\UserService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function store(CreateUserRequest $request)
    {
        return response()->json([
            'success' => $this->service->create($request->validated()),
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return response()->json([
            'success' => $this->service->update($user, $request->validated()),
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        return response()->json([
            'success' => $this->service->destroy($user),
        ], Response::HTTP_OK);
    }
}
