<?php

namespace App\Repositories;


use App\Models\ProjectManagement;
use Illuminate\Database\Eloquent\Collection;

class ProjectManagementRepository
{
    protected $model;

    public function __construct(ProjectManagement $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return ProjectManagement::all();
    }

    public function findProjectById($id)
    {
        return $this->model->find($id);
    }

    public function createProject(array $data)
    {
        return $this->model->create($data);
    }

    public function updateProject($id, array $data)
    {
        $project = $this->findProjectById($id);
        if ($project) {
            $project->update($data);
            return $project;
        }
        return null;
    }
    public function deleteProject($id)
    {
        $project = $this->findProjectById($id);
        if ($project) {
            $project->delete();
            return true;
        }
        return false;
    }
}
