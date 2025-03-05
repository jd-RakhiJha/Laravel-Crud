<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Managers\UserManager;
use App\Models\User;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private UserManager  $userManager
    ) {}

    public function index()
    {
        return UserData::collect($this->users->all());
    }

    public function store(UserData $userData)
    {
        return $this->users->create($userData);
    }

    public function show($id)
    {
        return $this->userManager->getUserById($id);
    }

    public function update(User $user, UserData $userData)
    {
        return $this->users->update($user, $userData);
    }

    public function destroy(User $user)
    {
        return $this->users->delete($user);
    }

    public function checkUserContacts($userId)
    {
        return $this->userManager->checkUserContacts($userId);
    }
}
