<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Models\User;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Users\UsersRepository;

class UserController extends Controller
{
    public function __construct(
        private UsersRepository $users,
        private PaymentRepository $payments
    ) {}

    public function index()
    {
        return UserData::collect($this->users->all());
    }

    public function store(UserData $userData)
    {
        return $this->users->create($userData);
    }

    public function show(User $user)
    {
        return $this->users->findById($user);
    }

    public function update(User $user, UserData $userData)
    {
        return $this->users->update($user, $userData);
    }

    public function destroy(User $user)
    {
        return $this->users->delete($user);
    }

    public function getUserPayments(User $user)
    {
        return $this->users->getUserPayments($user->id);
    }
}
