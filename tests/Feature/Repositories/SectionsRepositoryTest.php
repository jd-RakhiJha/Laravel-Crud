<?php

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\Sections;
use App\Data\SectionData;
use App\Repositories\Sections\SectionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;


class SectionsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private SectionRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new SectionRepository();
    }

    /** @test */
    public function it_can_get_all_sections()
    {
        Sections::factory()->count(3)->create();

        $result = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_find_section_by_id()
    {
        $section = Sections::factory()->create();

        $foundSection = $this->repository->findById($section->id);

        $this->assertInstanceOf(Sections::class, $foundSection);
        $this->assertEquals($section->id, $foundSection->id);
    }

    /** @test */
    public function it_returns_null_when_section_not_found()
    {
        $result = $this->repository->findById(999);

        $this->assertNull($result);
    }

    /** @test */
    public function it_can_create_new_section()
    {
        $sectionData = new SectionData(
            name: 'Science Section',
            class_id: 1,
            room_number: '101',
            capacity: 30
            // Add other fields as needed
        );

        $section = $this->repository->create($sectionData);

        $this->assertDatabaseHas('sections', [
            'name' => 'Science Section',
            'room_number' => '101',
            'capacity' => 30
        ]);
        $this->assertInstanceOf(Sections::class, $section);
    }

    /** @test */
    public function it_can_update_existing_section()
    {
        $section = Sections::factory()->create();
        $updateData = new SectionData(
            name: 'Updated Section',
            class_id: 2,
            room_number: '202',
            capacity: 40
            // Add other fields as needed
        );

        $updatedSection = $this->repository->update($section, $updateData);

        $this->assertEquals('Updated Section', $updatedSection->name);
        $this->assertEquals('202', $updatedSection->room_number);
        $this->assertEquals(40, $updatedSection->capacity);
        $this->assertDatabaseHas('sections', [
            'id' => $section->id,
            'name' => 'Updated Section'
        ]);
    }

    /** @test */
    public function it_can_delete_section()
    {
        $section = Sections::factory()->create();

        $result = $this->repository->delete($section->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('sections', ['id' => $section->id]);
    }
}
