<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardListResource;
use App\Models\Project;

class WelcomeController extends Controller
{
    public function index()
    {

        $projects = Project::orderBy('id', 'desc');

        $projects = DashboardListResource::collection($projects->get());

        // return $projects;

        return view('welcome', ['projects' => $projects]);
    }
}
