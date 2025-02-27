<?php

namespace App\Http\Controllers;

use App\Data\OrderData;
use App\Managers\OrderManager;
use App\Models\Order;
use App\Repositories\Orders\OrdersRepository;

class OrderController extends Controller
{
    public function __construct(
        private OrderManager $orderManager,
        private OrdersRepository $order
    ) {}

    public function index()
    {
        return OrderData::collect($this->orderManager->all());
    }

    public function show(Order $order)
    {
        return $this->order->findById($order);
    }

    public function store(OrderData $orderData)
    {
        return $this->order->create($orderData);
    }

    public function update(Order $order, OrderData $orderData)
    {
        return $this->order->update($order, $orderData);
    }

    public function destroy($id)
    {
        return $this->order->delete($id);
    }
}
