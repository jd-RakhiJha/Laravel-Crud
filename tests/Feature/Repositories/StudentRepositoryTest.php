<?php

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Sections;
use App\Data\StudentData;
use App\Repositories\Student\StudentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private StudentRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StudentRepository();
    }

    /** @test */
    public function it_can_get_all_students_with_pagination()
    {
        // Create test data
        $class = Classes::factory()->create();
        $section = Sections::factory()->create();

        Student::factory()->count(15)->create([
            'class_id' => $class->id,
            'section_id' => $section->id
        ]);

        // Test pagination
        $result = $this->repository->all(10);

        $this->assertCount(10, $result);
        $this->assertEquals(15, $result->total());
        $this->assertTrue($result->hasMorePages());
    }

    /** @test */
    public function it_can_get_classes_with_sections()
    {
        // Create test data
        $class = Classes::factory()->create();
        $sections = Sections::factory()->count(3)->create([
            'class_id' => $class->id
        ]);

        $result = $this->repository->classes_with_sections();

        $this->assertCount(1, $result);
        $this->assertEquals($class->id, $result[0]['id']);
        $this->assertEquals($class->name, $result[0]['name']);
        $this->assertCount(3, $result[0]['sections']);
    }

    /** @test */
    public function it_can_find_student_by_id()
    {
        $student = Student::factory()->create();

        $result = $this->repository->findById($student->id);

        $this->assertNotNull($result);
        $this->assertEquals($student->id, $result->id);
    }

    /** @test */
    public function it_returns_null_when_student_not_found()
    {
        $result = $this->repository->findById(999);

        $this->assertNull($result);
    }

    /** @test */
    public function it_can_create_new_student()
    {
        $class = Classes::factory()->create();
        $section = Sections::factory()->create();

        $studentData = new StudentData(
            name: 'John Doe',
            email: 'john@example.com',
            class_id: $class->id,
            section_id: $section->id,
            roll_number: '12345',
            phone: '1234567890',
            address: '123 Main St'
        );

        $result = $this->repository->create($studentData);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('john@example.com', $result->email);
        $this->assertEquals($class->id, $result->class_id);
        $this->assertEquals($section->id, $result->section_id);
    }

    /** @test */
    public function it_can_update_existing_student()
    {
        $student = Student::factory()->create();
        $newClass = Classes::factory()->create();
        $newSection = Sections::factory()->create();

        $studentData = new StudentData(
            name: 'Updated Name',
            email: 'updated@example.com',
            class_id: $newClass->id,
            section_id: $newSection->id,
            roll_number: '54321',
            phone: '0987654321',
            address: '456 New St'
        );

        $result = $this->repository->update($student, $studentData);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals('Updated Name', $result->name);
        $this->assertEquals('updated@example.com', $result->email);
        $this->assertEquals($newClass->id, $result->class_id);
        $this->assertEquals($newSection->id, $result->section_id);
    }

    /** @test */
    public function it_can_delete_student()
    {
        $student = Student::factory()->create();

        $result = $this->repository->delete($student->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    /** @test */
    public function it_returns_false_when_deleting_nonexistent_student()
    {
        $result = $this->repository->delete(999);

        $this->assertFalse($result);
    }
}
