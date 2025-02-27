<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Collection;

class UsersRepository
{
    public function all(): Collection
    {
        return User::with('product')->get()->collect();
    }

    public function findById($id): User
    {
        return User::with('product')->findOrFail($id);
    }

    public function create($userData): User
    {
        return User::create($userData->toArray());
    }

    public function update($id,  $userData): User
    {
        $user = User::findOrFail($id);
        $user->update($userData->toArray());
        return $user;
    }

    public function delete($id): bool
    {
        return User::destroy($id);
    }
}
