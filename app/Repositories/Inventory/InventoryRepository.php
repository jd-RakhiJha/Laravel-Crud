<?php

namespace App\Repositories\Inventory;

use App\Models\Inventory;
use App\Data\InventoryData;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class InventoryRepository
{
    public function all($perPage = 10)
    {
        return Inventory::with(['category', 'inventoryable'])
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Inventory
    {
        return Inventory::with(['category', 'inventoryable'])->find($id);
    }

    public function create(InventoryData $inventoryData): Inventory
    {
        return Inventory::create($inventoryData->toArray());
    }

    public function update(Inventory $inventory, InventoryData $inventoryData): Inventory
    {
        $inventory->update($inventoryData->toArray());
        return $inventory->fresh(['category', 'inventoryable']);
    }

    public function delete(int $id): bool
    {
        return Inventory::destroy($id);
    }

    public function getLowStockItems(): Collection
    {
        return Inventory::whereRaw('quantity <= minimum_stock')
            ->with(['category', 'inventoryable'])
            ->get();
    }

    public function getItemsByCategory(int $categoryId)
    {
        return Inventory::where('category_id', $categoryId)
            ->with(['category', 'inventoryable'])
            ->paginate(10);
    }

    public function getItemsByType(string $type)
    {
        return Inventory::where('inventoryable_type', $type)
            ->with(['category', 'inventoryable'])
            ->paginate(10);
    }

    public function updateStock(int $id, int $quantity, string $operation = 'add'): Inventory
    {
        $inventory = $this->findById($id);

        if ($operation === 'add') {
            $inventory->quantity += $quantity;
            $inventory->last_restock_quantity = $quantity;
            $inventory->last_restock_date = now();
        } else {
            $inventory->quantity -= $quantity;
        }

        $inventory->save();
        return $inventory->fresh(['category', 'inventoryable']);
    }

    public function attachToModel(Model $model, InventoryData $inventoryData): Inventory
    {
        $inventoryData->inventoryable_type = get_class($model);
        $inventoryData->inventoryable_id = $model->id;

        return $this->create($inventoryData);
    }

    public function getModelInventory(Model $model)
    {
        return Inventory::where('inventoryable_type', get_class($model))
            ->where('inventoryable_id', $model->id)
            ->with(['category'])
            ->get();
    }
}
