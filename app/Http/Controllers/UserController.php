<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Managers\UserManager;
use App\Models\User;
use App\Repositories\Users\UsersRepository;

class UserController extends Controller
{
    public function __construct(
        private UsersRepository $users,
        private UserManager $userManager
    ) {}

    public function index()
    {
        return $this->userManager->getAllUsers();
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

    public function getUserWithOrders(User $user)
    {
        return $this->userManager->getUserWithOrders($user->id);
    }

    // public function getUserPayments(User $user)
    // {
    //     return $this->users->getUserPayments($user->id);
    // }
}
