<?php

namespace App\Managers;

use App\Repositories\Order\OrderRepository;
use App\Data\OrderData;
use App\Models\Order;

class OrderManager
{
    protected OrderRepository $orders;

    public function __construct()
    {
        $this->orders = new OrderRepository;
    }
}
