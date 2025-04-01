<?php

namespace App\Repositories\Sections;

use Illuminate\Support\Collection;
use App\Models\Sections;
use App\Data\SectionData;

class SectionRepository
{
    public function all(): Collection
    {
        return Sections::all();
    }

    public function findById(int $id): ?Sections
    {
        return Sections::find($id);
    }

    public function create(SectionData $sectionData): Sections
    {
        return Sections::create($sectionData->toArray());
    }

    public function update(Sections $section, SectionData $sectionData): Sections
    {
        $section->update($sectionData->toArray());
        return $section;
    }

    public function delete(int $id): bool
    {
        return Sections::destroy($id);
    }
}
