<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_get_all_inventory_items()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        Inventory::factory()->count(3)->create([
            'category_id' => $category->id,
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id
        ]);

        $response = $this->getJson('/api/inventory');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'quantity',
                            'unit_price',
                            'category_id',
                            'minimum_stock',
                            'location',
                            'status',
                            'inventoryable_type',
                            'inventoryable_id',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'current_page',
                    'total'
                ]
            ]);
    }

    /** @test */
    public function it_can_create_new_inventory_item()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Test Item',
            'description' => 'Test Description',
            'quantity' => 100,
            'unit_price' => 10.99,
            'category_id' => $category->id,
            'minimum_stock' => 20,
            'location' => 'Warehouse A',
            'status' => 'active'
        ];

        $response = $this->postJson('/api/inventory', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'quantity',
                    'unit_price',
                    'category_id',
                    'minimum_stock',
                    'location',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'name' => 'Test Item',
            'quantity' => 100,
            'unit_price' => 10.99
        ]);
    }

    /** @test */
    public function it_can_update_inventory_item()
    {
        $inventory = Inventory::factory()->create();
        $newCategory = Category::factory()->create();

        $data = [
            'name' => 'Updated Item',
            'description' => 'Updated Description',
            'quantity' => 200,
            'unit_price' => 15.99,
            'category_id' => $newCategory->id,
            'minimum_stock' => 30,
            'location' => 'Warehouse B',
            'status' => 'active'
        ];

        $response = $this->putJson("/api/inventory/{$inventory->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'quantity',
                    'unit_price',
                    'category_id',
                    'minimum_stock',
                    'location',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'name' => 'Updated Item',
            'quantity' => 200,
            'unit_price' => 15.99
        ]);
    }

    /** @test */
    public function it_can_delete_inventory_item()
    {
        $inventory = Inventory::factory()->create();

        $response = $this->deleteJson("/api/inventory/{$inventory->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ]);

        $this->assertDatabaseMissing('inventories', [
            'id' => $inventory->id
        ]);
    }

    /** @test */
    public function it_can_get_low_stock_items()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        Inventory::factory()->count(3)->create([
            'category_id' => $category->id,
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id,
            'quantity' => 5,
            'minimum_stock' => 10
        ]);

        $response = $this->getJson('/api/inventory/low-stock');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'quantity',
                        'minimum_stock'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_update_stock_quantity()
    {
        $inventory = Inventory::factory()->create([
            'quantity' => 100
        ]);

        $data = [
            'quantity' => 50,
            'operation' => 'add'
        ];

        $response = $this->postJson("/api/inventory/{$inventory->id}/stock", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'quantity',
                    'last_restock_quantity',
                    'last_restock_date'
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'quantity' => 150
        ]);
    }

    /** @test */
    public function it_can_attach_inventory_to_model()
    {
        $category = Category::factory()->create();
        $student = Student::factory()->create();

        $data = [
            'model_type' => Student::class,
            'model_id' => $student->id,
            'name' => 'Student Item',
            'description' => 'Student Description',
            'quantity' => 50,
            'unit_price' => 5.99,
            'category_id' => $category->id,
            'minimum_stock' => 10,
            'location' => 'Classroom A',
            'status' => 'active'
        ];

        $response = $this->postJson('/api/inventory/attach', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'inventoryable_type',
                    'inventoryable_id'
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'name' => 'Student Item',
            'inventoryable_type' => Student::class,
            'inventoryable_id' => $student->id
        ]);
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

        $data = [
            'model_type' => Student::class,
            'model_id' => $student->id
        ];

        $response = $this->getJson('/api/inventory/model?' . http_build_query($data));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'inventoryable_type',
                        'inventoryable_id'
                    ]
                ]
            ]);
    }
}
