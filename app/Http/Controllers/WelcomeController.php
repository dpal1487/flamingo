<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectListResource;
use App\Models\Project;

class WelcomeController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->get();

        $projects = ProjectListResource::collection($projects);

        return view('welcome', compact('projects'));
    }
}
