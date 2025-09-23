<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Service\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = Project::with(['user', 'file'])->get();
        return view('backend.projects.index', [
           'projects' => $projects 
        ]);
    }

    public function create()
    {
        return view('backend.projects.create');
    }

    public function store(ProjectStoreRequest $request, Project $project)
    {
        $data = $request->only([
            'project_title', 'description', 'project_url', 'github_url', 'image'
        ]);

        $project = $this->projectService->handleProject($data, $request);

        return to_route('admin.project.index')->with([
            'success' => 'New Project successfully created.'
        ]);
    }

    public function edit(Project $project)
    {
        return view('backend.projects.edit', [
            'project' => $project
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $data = $request->only([
            'project_title', 'image', 'description', 'github_url', 'project_url'
        ]);

        $project = $this->projectService->handleProjectUpdate($data, $request, $project);

        return to_route('admin.project.index')->with([
            'success' => 'Project successfully updated.'
        ]);
    }

    public function destroy(Project $project)
    {
        $project = $this->projectService->handleDeleteProject($project);

        return to_route('admin.project.index')->with([
            'success' => 'Project successfully deleted.'
        ]);
    }
}
