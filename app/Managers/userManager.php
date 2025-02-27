<?php

namespace App\Managers;

use App\Data\UserData;
use App\Repositories\Users\UsersRepository;
use App\Models\User;

class UserManager
{
    protected UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getAllUsers()
    {
        return $this->usersRepository->all();
    }

    public function findById(User $user)
    {
        return $this->usersRepository->findById($user->id);
    }

    public function create(UserData $userData)
    {
        return $this->usersRepository->create($userData);
    }

    public function update(User $user, UserData $userData)
    {
        return $this->usersRepository->update($user->id, $userData);
    }

    public function delete(User $user)
    {
        return $this->usersRepository->delete($user->id);
    }
}
