<?php

namespace App\Repositories\Orders;

use App\Data\OrderData;

interface OrdersRepositoryInterface
{
    public function all();
    public function findById($id);
    public function create(OrderData $data);
    public function update($id, OrderData $data);
    public function delete($id);
}
