<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Classes;
use App\Repositories\ClassesRepository;
use Illuminate\Support\Collection;
use App\Data\ClassesData;


class ClassesRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    private ClassesRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ClassesRepository();
    }

    /** @test */
    public function it_can_get_all_classes()
    {
        Classes::factory()->count(5)->create();

        $result = $this->repository->all();

        $this->assertCount(5, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    /** @test */
    public function it_can_find_class_by_id()
    {
        $class = Classes::factory()->create();

        $result = $this->repository->findById($class->id);

        $this->assertNotNull($result);
        $this->assertEquals($class->id, $result->id);
        $this->assertInstanceOf(Classes::class, $result);
    }

    /** @test */
    public function it_returns_null_when_class_not_found()
    {
        $result = $this->repository->findById(999);

        $this->assertNull($result);
    }

    /** @test */
    public function it_can_create_new_class()
    {
        $classData = new ClassesData(
            name: 'Mathematics',
            description: 'Advanced Mathematics Course'
        );

        $result = $this->repository->create($classData);

        $this->assertInstanceOf(Classes::class, $result);
        $this->assertEquals('Mathematics', $result->name);
        $this->assertEquals('Advanced Mathematics Course', $result->description);
        $this->assertDatabaseHas('classes', [
            'name' => 'Mathematics',
            'description' => 'Advanced Mathematics Course'
        ]);
    }

    /** @test */
    public function it_can_update_existing_class()
    {
        $class = Classes::factory()->create();

        $classData = new ClassesData(
            name: 'Updated Class',
            description: 'Updated Description'
        );

        $result = $this->repository->update($class, $classData);

        $this->assertInstanceOf(Classes::class, $result);
        $this->assertEquals('Updated Class', $result->name);
        $this->assertEquals('Updated Description', $result->description);
        $this->assertDatabaseHas('classes', [
            'id' => $class->id,
            'name' => 'Updated Class',
            'description' => 'Updated Description'
        ]);
    }

    /** @test */
    public function it_can_delete_class()
    {
        $class = Classes::factory()->create();

        $result = $this->repository->delete($class->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('classes', ['id' => $class->id]);
    }
}
