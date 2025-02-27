<?php

namespace App\Http\Controllers;

use App\Data\OrderData;
use App\Managers\OrderManager;
use App\Models\Order;
use App\Repositories\Orders\OrdersRepository;

class OrderController extends Controller
{
    public function __construct(
        private OrdersRepository $orders
    ) {}

    public function index()
    {
        return OrderData::collect($this->orders->all());
    }

    public function show(Order $order)
    {
        return $this->orders->findById($order);
    }

    public function store(OrderData $orderData)
    {
        return $this->orders->create($orderData);
    }

    public function update(Order $order, OrderData $orderData)
    {
        return $this->orders->update($order, $orderData);
    }

    public function destroy($id)
    {
        return $this->orders->delete($id);
    }
}
