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
    public function store()
    {
        Project::create(request(['title', 'description']));
    }
}
