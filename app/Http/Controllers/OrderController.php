<?php

namespace App\Http\Controllers;

use App\Data\OrderData;
use App\Managers\OrderManager;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct(
        private OrderManager $orderManager
    ) {}

    public function index()
    {
        return OrderData::collect($this->orderManager->getAllOrders());
    }

    public function show(Order $order)
    {
        return $this->orderManager->getOrderById($order);
    }

    public function store(OrderData $orderData)
    {
        return $this->orderManager->createOrder($orderData);
    }

    public function update(Order $order, OrderData $orderData)
    {
        return $this->orderManager->updateOrder($order, $orderData);
    }

    public function destroy(Order $order)
    {
        return $this->orderManager->deleteOrder($order);
    }
}
