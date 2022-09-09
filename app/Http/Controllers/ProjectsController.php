<?php

namespace App\Http\Controllers;

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
    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update([
            'notes' => request('notes')
        ]);
        return redirect($project->path());
    }
}
