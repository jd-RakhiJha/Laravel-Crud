<?php

namespace App\Http\Controllers;

use App\Data\OrderData;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;


class OrderController extends Controller
{
    public function __construct(
        private OrderRepository $orders
    ) {}

    public function index()
    {
        return OrderData::collect($this->orders->all());
    }

    public function show(Order $order)
    {
        return $this->orders->findById($order->id);
    }

    public function store(OrderData $orderData)
    {
        return $this->orders->create($orderData);
    }

    public function update(Order $order, OrderData $orderData)
    {
        return $this->orders->update($order, $orderData);
    }

    public function destroy(Order $order)
    {
        return $this->orders->delete($order);
    }
}
