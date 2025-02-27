<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Models\User;
use Illuminate\Http\Request;
use App\Managers\userManager;
use App\Repositories\Users\UsersRepository;

class UserController extends Controller
{
    public function __construct(
        private UserManager $userManager,
        private UsersRepository $users
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

    public function update($id, UserData $userData)
    {
        return $this->userManager->updateUser($id, $userData);
    }

    public function destroy($id)
    {
        return $this->userManager->deleteUser($id);
    }
}
