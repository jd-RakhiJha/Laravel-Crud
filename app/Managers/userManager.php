<?php

namespace App\Managers;

use App\Data\UserData;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\UsersRepositoryInterface;

class UserManager
{
    protected $UsersRepository;

    public function __construct(UsersRepository $usersRepository, UserData $userData)
    {
        $this->UsersRepository = $usersRepository;
    }

    public function getAllUsers()
    {
        return $this->UsersRepository->all();
    }

    public function getUserById($id)
    {
        return $this->UsersRepository->findById($id);
    }

    public function createUser(UserData $userData)
    {
        return $this->UsersRepository->create($userData);
    }

    public function updateUser($id, UserData $userData)
    {
        return $this->UsersRepository->update($id, $userData);
    }

    public function deleteUser($id)
    {
        return $this->UsersRepository->delete($id);
    }
}
