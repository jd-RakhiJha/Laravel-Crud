<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Models\User;
use Illuminate\Http\Request;
use App\Managers\UserManager;

class UserController extends Controller
{
    public function __construct(
        private UserManager $userManager
    ) {}

    public function index()
    {
        return UserData::collect($this->userManager->getAllUsers());
    }

    public function store(UserData $userData)
    {
        return $this->userManager->createUser($userData);
    }

    public function show(User $user)
    {
        return $this->userManager->getUserById($user);
    }

    public function update(User $user, UserData $userData)
    {
        return $this->userManager->updateUser($user, $userData);
    }

    public function destroy(User $user)
    {
        return $this->userManager->deleteUser($user);
    }
}
