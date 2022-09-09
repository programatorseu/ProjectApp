<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    //
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attr = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);
        $attr['user_id'] = auth()->id();
        $project = Project::create($attr);
        return redirect($project->path());
    }
    public function update(UpdateProjectRequest $request, Project $project,)
    {
        $project->update($request->validated());
        return redirect($project->path());
    }
}
