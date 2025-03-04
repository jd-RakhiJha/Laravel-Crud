<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Models\User;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $users
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
        return $this->users->findById($user->id);
    }

    public function update(User $user, UserData $userData)
    {
        return $this->users->update($user, $userData);
    }

    public function destroy(User $user)
    {
        return $this->users->delete($user);
    }
}
