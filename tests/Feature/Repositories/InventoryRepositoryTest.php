<?php

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Student;
use App\Data\InventoryData;
use App\Repositories\Inventory\InventoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private InventoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InventoryRepository();
    }

    /** @test */
    public function it_can_get_all_inventory_items_with_pagination()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        Inventory::factory()->count(15)->create([
            'category_id' => $category->id,
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id
        ]);

        $result = $this->repository->all(10);

        $this->assertCount(10, $result->items());
        $this->assertEquals(15, $result->total());
        $this->assertTrue($result->hasMorePages());
    }

    /** @test */
    public function it_can_find_inventory_item_by_id()
    {
        $inventory = Inventory::factory()->create();

        $result = $this->repository->findById($inventory->id);

        $this->assertNotNull($result);
        $this->assertEquals($inventory->id, $result->id);
    }

    /** @test */
    public function it_returns_null_when_inventory_item_not_found()
    {
        $result = $this->repository->findById(999);

        $this->assertNull($result);
    }

    /** @test */
    public function it_can_create_new_inventory_item()
    {
        $category = Category::factory()->create();

        $inventoryData = new InventoryData(
            name: 'Test Item',
            description: 'Test Description',
            quantity: 100,
            unit_price: 10.99,
            category_id: $category->id,
            minimum_stock: 20,
            location: 'Warehouse A',
            status: 'active'
        );

        $result = $this->repository->create($inventoryData);

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertEquals('Test Item', $result->name);
        $this->assertEquals(100, $result->quantity);
        $this->assertEquals(10.99, $result->unit_price);
    }

    /** @test */
    public function it_can_update_existing_inventory_item()
    {
        $inventory = Inventory::factory()->create();
        $newCategory = Category::factory()->create();

        $inventoryData = new InventoryData(
            name: 'Updated Item',
            description: 'Updated Description',
            quantity: 200,
            unit_price: 15.99,
            category_id: $newCategory->id,
            minimum_stock: 30,
            location: 'Warehouse B',
            status: 'active'
        );

        $result = $this->repository->update($inventory, $inventoryData);

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertEquals('Updated Item', $result->name);
        $this->assertEquals(200, $result->quantity);
        $this->assertEquals(15.99, $result->unit_price);
    }

    /** @test */
    public function it_can_delete_inventory_item()
    {
        $inventory = Inventory::factory()->create();

        $result = $this->repository->delete($inventory->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('inventories', ['id' => $inventory->id]);
    }

    /** @test */
    public function it_can_get_low_stock_items()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        // Create items with low stock
        Inventory::factory()->count(3)->create([
            'category_id' => $category->id,
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id,
            'quantity' => 5,
            'minimum_stock' => 10
        ]);

        $result = $this->repository->getLowStockItems();

        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_update_stock_quantity()
    {
        $inventory = Inventory::factory()->create([
            'quantity' => 100
        ]);

        $result = $this->repository->updateStock($inventory->id, 50, 'add');

        $this->assertEquals(150, $result->quantity);
        $this->assertEquals(50, $result->last_restock_quantity);
        $this->assertNotNull($result->last_restock_date);
    }

    /** @test */
    public function it_can_reduce_stock_quantity()
    {
        $inventory = Inventory::factory()->create([
            'quantity' => 100
        ]);

        $result = $this->repository->updateStock($inventory->id, 30, 'subtract');

        $this->assertEquals(70, $result->quantity);
    }

    /** @test */
    public function it_can_attach_inventory_to_model()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        $inventoryData = new InventoryData(
            name: 'Student Item',
            description: 'Student Description',
            quantity: 50,
            unit_price: 5.99,
            category_id: $category->id,
            minimum_stock: 10,
            location: 'Classroom A',
            status: 'active'
        );

        $result = $this->repository->attachToModel($student, $inventoryData);

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertEquals(Student::class, $result->inventoryable_type);
        $this->assertEquals($student->id, $result->inventoryable_id);
    }

    /** @test */
    public function it_can_get_model_inventory()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        Inventory::factory()->count(3)->create([
            'category_id' => $category->id,
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id
        ]);

        $result = $this->repository->getModelInventory($student);

        $this->assertCount(3, $result);
        $this->assertEquals(Student::class, $result->first()->inventoryable_type);
        $this->assertEquals($student->id, $result->first()->inventoryable_id);
    }
}
