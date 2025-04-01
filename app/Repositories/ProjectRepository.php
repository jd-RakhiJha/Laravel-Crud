<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{

    public function all()
    {
        return Project::all();
    }
    public function find(int $id): ?Project
    {
        return Project::find($id);
    }

    public function create(array $projectData): Project
    {
        return Project::create($projectData);
    }

    public function update(Project $project, array $projectData): Project
    {
        $project->update($projectData);
        return $project;
    }

    public function delete(int $id): bool
    {
        return Project::destroy($id) > 0;
    }
}
