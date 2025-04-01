<?php

namespace App\Http\Controllers;

use App\Data\SectionData;
use App\Http\Requests\SectionRequest; // Ensure this class exists in the specified namespace or update the namespace if incorrect.
use App\Models\Sections;
use App\Repositories\Sections\SectionRepository;
use Inertia\Inertia;
use Inertia\Response;

class SectionController extends Controller
{
    public function __construct(protected SectionRepository $sections) {}

    public function index()
    {
        return SectionData::collect($this->getAllContacts());
    }

    public function store(SectionData $sectionData)
    {
        return $this->sections->create($sectionData);
    }

    public function update(SectionData $sectionData, Sections $sections)
    {
        return $this->sections->update($sections, $sectionData);
    }

    public function destroy(Sections $sections)
    {
        return $this->sections->delete($sections->id);
    }
}
