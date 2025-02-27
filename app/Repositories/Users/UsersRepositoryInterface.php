<?php

namespace App\Repositories\Users;

use App\Data\UserData;


interface UsersRepositoryInterface
{
    public function all();
    public function findById($id);
    public function create(UserData $data);
    public function update($id, UserData $data);
    public function delete($id);
}
