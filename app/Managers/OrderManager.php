<?php

namespace App\Managers;

use App\Repositories\Orders\OrdersRepository;
use App\Data\OrderData;
use App\Models\Order;

class OrderManager
{
    protected OrdersRepository $orders;

    public function __construct()
    {
        $this->orders = new OrdersRepository;
    }
}
