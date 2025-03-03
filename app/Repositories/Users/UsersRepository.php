<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Collection;

class UsersRepository
{
    public function all(): Collection
    {
        return User::with('orders')->get();
    }

    public function findById($id): User
    {
        return User::with('orders')->findOrFail($id);
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

    public function getUserWithOrders($userId)
    {
        return User::with('orders')->find($userId);
    }

    // public function getUserPayments($userId): Collection
    // {
    //     return User::findOrFail($userId)->payments;
    // }
}
