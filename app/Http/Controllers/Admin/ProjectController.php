<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Service\ProjectService;
use Illuminate\Http\Request;

class ProjectController
{
    public function __construct(private ProjectService $projectService) {}

    public function index()
    {
        $projects = Project::with(['user', 'file'])->paginate(5);
        return view('backend.projects.index', [
           'projects' => $projects 
        ]);
    }

    public function create()
    {
        $technologies = Technology::all();
        return view('backend.projects.create', [
            'technologies' => $technologies
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {
        $this->projectService->handleCreateProject($request->validated(), $request->file('image'));

        return to_route('admin.project.index')->with([
            'success' => 'New Project successfully created.'
        ]);
    }

    public function edit(Project $project)
    {
        $technologies = Technology::all();
        return view('backend.projects.edit', [
            'project' => $project,
            'technologies' => $technologies
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $this->projectService->handleProjectUpdate($request->validated(), $request->file('image'), $project);

        return to_route('admin.project.index')->with([
            'success' => 'Project successfully updated.'
        ]);
    }

    public function destroy(Project $project)
    {
        $this->projectService->handleDeleteProject($project);

        return to_route('admin.project.index')->with([
            'success' => 'Project successfully deleted.'
        ]);
    }
}
