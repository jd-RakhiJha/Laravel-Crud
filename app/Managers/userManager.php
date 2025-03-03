<?php

namespace App\Managers;

use App\Repositories\Users\UsersRepository;

class UserManager
{
    public function __construct(protected UsersRepository $users) {}

    public function getAllUsers()
    {
        return $this->users->all();
    }

    public function getUserWithOrders($userId)
    {
        return $this->users->getUserWithOrders($userId);
    }
}
