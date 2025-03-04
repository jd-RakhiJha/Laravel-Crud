<?php

namespace App\Repositories\Order;

use App\Data\OrderData;
use App\Models\Order;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function all(): Collection
    {
        return Order::all();
    }

    public function findById(int $id): ?Order
    {
        return Order::find($id);
    }

    public function create(OrderData $orderData): Order
    {
        return Order::create($orderData->toArray());
    }

    public function update(Order $order, OrderData $data): Order
    {
        $order->update($data->toArray());
        return $order;
    }

    public function delete($id): bool
    {
        return Order::destroy($id);
    }
}
