<?php

namespace App\Managers;

use App\Repositories\User\UserRepository;

class UserManager
{
    protected UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository;
    }
}
