<?php

namespace Modules\ProjectManagement\Http\Controllers;

use App\Repositories\ProjectManagementRepository;
use Modules\ProjectManagement\Data\ProjectData;
use Modules\ProjectManagement\Entities\Project;
use Modules\ProjectManagement\Repositories\ProjecrtManagementRepository;
use Illuminate\Routing\Controller;
use Modules\ProjectManagement\Data\ProjectManagementData;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectManagementRepository $projects
    ) {}

    public function index()
    {
        return ProjectManagementData::collect($this->projects->all());
    }

    public function store(ProjectData $projectData)
    {
        return $this->projects->create($projectData);
    }

    public function show(Project $project)
    {
        return $this->projects->findById($project->id);
    }

    public function update(Project $project, ProjectData $projectData)
    {
        return $this->projects->update($project, $projectData);
    }

    public function destroy(Project $project)
    {
        return $this->projects->delete($project);
    }
}
