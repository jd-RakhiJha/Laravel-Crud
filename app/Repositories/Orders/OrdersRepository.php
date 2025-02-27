<?php

namespace App\Repositories\Orders;

use App\Data\OrderData;
use App\Models\Order;

class OrdersRepository
{
    public function all()
    {
        return Order::all();
    }

    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function create(OrderData $orderData)
    {
        return Order::create($orderData->toArray());
    }

    public function update(Order $id, OrderData $data)
    {
        $order = Order::findOrFail($id);
        $order->update($data->toArray());
        return $order;
    }

    public function delete($id)
    {
        return Order::destroy($id);
    }
}
