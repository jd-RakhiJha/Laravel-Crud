<?php

namespace App\Managers;

use App\Repositories\Users\UsersRepository;

class UserManager
{
    protected UsersRepository $users;

    public function __construct()
    {
        $this->users =  new UsersRepository;
    }
}
