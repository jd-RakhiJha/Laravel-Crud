<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Data\InventoryData;
use App\Repositories\Inventory\InventoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    public function __construct(protected InventoryRepository $repository) {}

    /**
     * Get all inventory items with pagination
     */
    public function index(): JsonResponse
    {
        $perPage = request()->input('per_page', 10);
        $items = $this->repository->all($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Get a specific inventory item
     */
    public function show(int $id): JsonResponse
    {
        $item = $this->repository->findById($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inventory item not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ]);
    }

    /**
     * Create a new inventory item
     */
    public function store(InventoryData $inventoryData): JsonResponse
    {
        $item = $this->repository->create($inventoryData);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Update an existing inventory item
     */
    public function update(InventoryData $inventoryData, Inventory $inventory): JsonResponse
    {
        $updatedItem = $this->repository->update($inventory, $inventoryData);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory item updated successfully',
            'data' => $updatedItem
        ]);
    }

    /**
     * Delete an inventory item
     */
    public function destroy(Inventory $inventory): JsonResponse
    {
        $this->repository->delete($inventory->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory item deleted successfully'
        ]);
    }

    /**
     * Get low stock items
     */
    public function lowStock(): JsonResponse
    {
        $items = $this->repository->getLowStockItems();

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Get items by category
     */
    public function byCategory(int $categoryId): JsonResponse
    {
        $items = $this->repository->getItemsByCategory($categoryId);

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Get items by type
     */
    public function byType(string $type): JsonResponse
    {
        $items = $this->repository->getItemsByType($type);

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Update stock quantity
     */
    public function updateStock(int $id, int $quantity, string $operation = 'add'): JsonResponse
    {
        $updatedItem = $this->repository->updateStock($id, $quantity, $operation);

        return response()->json([
            'status' => 'success',
            'message' => 'Stock updated successfully',
            'data' => $updatedItem
        ]);
    }

    /**
     * Attach inventory to a model
     */
    public function attachToModel(InventoryData $inventoryData, string $modelType, int $modelId): JsonResponse
    {
        $model = $modelType::find($modelId);

        if (!$model) {
            return response()->json([
                'status' => 'error',
                'message' => 'Model not found'
            ], 404);
        }

        $item = $this->repository->attachToModel($model, $inventoryData);

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory attached to model successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Get model's inventory
     */
    public function getModelInventory(string $modelType, int $modelId): JsonResponse
    {
        $model = $modelType::find($modelId);

        if (!$model) {
            return response()->json([
                'status' => 'error',
                'message' => 'Model not found'
            ], 404);
        }

        $items = $this->repository->getModelInventory($model);

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }
}
