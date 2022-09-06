<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::all()
        ]);
    }
    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project
        ]);
    }
    public function store()
    {
        $attr = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $attr['user_id'] = auth()->id();
        Project::create($attr);
        return redirect('/');
    }
}
