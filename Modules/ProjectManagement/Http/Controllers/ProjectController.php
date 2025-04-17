
<?php


use App\Repositories\ProjectRepository;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectRepository $projects,
    ) {}

    public function index()
    {
        return $this->projects->all();
    }

    public function show(Project $project)
    {
        return $this->projects->find($project->id);
    }

    public function store(Request $request)
    {
        $projectData = $request->all();
        return $this->projects->create($projectData);
    }

    public function update(Request $request, Project $project)
    {
        $projectData = $request->all();
        return $this->projects->update($project, $projectData);
    }

    public function destroy(Project $project)
    {
        return $this->projects->delete($project->id);
    }
}
