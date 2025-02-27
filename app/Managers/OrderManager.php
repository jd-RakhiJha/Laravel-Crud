<?php

namespace App\Managers;

use App\Repositories\Orders\OrdersRepository;
use App\Data\OrderData;
use App\Models\Order;

class OrderManager
{
    protected OrdersRepository $ordersRepository;

    public function __construct(OrdersRepository $orders)
    {
        $this->ordersRepository = $orders;
    }

    public function all()
    {
        return $this->ordersRepository->all();
    }

    public function findById(Order $order)
    {
        return $this->ordersRepository->findById($order->id);
    }

    public function create(OrderData $data)
    {
        return $this->ordersRepository->create($data);
    }

    public function update(Order $order, OrderData $data)
    {
        return $this->ordersRepository->update($order->id, $data);
    }

    public function delete($id)
    {
        return $this->ordersRepository->delete($id);
    }
}
