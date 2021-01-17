<?php

namespace App\Domains\Users\Services;

use App\Domains\Users\Models\User;

class UserService
{
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => $data['document'],
            'document_type' => strlen($data['document']) == 11 ? 'cpf' : 'cnpj',
            'password' => bcrypt($data['password']),
        ]);
    }

    public function update(User $user, array $data): bool
    {
        return (bool) $user->update($data);
    }

    public function destroy(User $authUser, User $user): bool
    {
        return $authUser->id == $user->id
            ? (bool) $user->delete()
            : false;
    }
}
