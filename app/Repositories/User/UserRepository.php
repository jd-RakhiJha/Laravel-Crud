<?php

namespace App\Repositories\User;

use App\Data\UserData;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    public function all(): Collection
    {
        return User::all();
    }

    public function findById($id): ?User
    {
        return User::find($id);
    }

    public function create(UserData $userData): User
    {
        return User::create($userData->toArray());
    }

    public function update(User $user, UserData $userData): User
    {
        $user->update($userData->toArray());
        return $user;
    }

    public function delete($id): bool
    {
        return User::destroy($id);
    }
}
