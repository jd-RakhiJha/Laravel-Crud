<?php

namespace App\Repositories\Users;

use App\Data\UserData;
use App\Models\User;

interface UsersRepositoryInterface
{
    public function all();
    public function findById($id);
    public function create(UserData $data);
    public function update(User $id, UserData $data);
    public function delete(User $user);
}
