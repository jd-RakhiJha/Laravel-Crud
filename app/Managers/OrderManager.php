<?php

namespace App\Managers;

use App\Repositories\Orders\OrdersRepositoryInterface;
use App\Data\OrderData;
use App\Models\Order;

class OrderManager
{
    protected OrdersRepositoryInterface $ordersRepository;

    public function __construct(OrdersRepositoryInterface $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function getAllOrders()
    {
        return $this->ordersRepository->all();
    }

    public function getOrderById(Order $order)
    {
        return $this->ordersRepository->findById($order->id);
    }

    public function createOrder(OrderData $data)
    {
        return $this->ordersRepository->create($data);
    }

    public function updateOrder(Order $order, OrderData $data)
    {
        return $this->ordersRepository->update($order->id, $data);
    }

    public function deleteOrder(Order $order)
    {
        return $this->ordersRepository->delete($order->id);
    }
}
