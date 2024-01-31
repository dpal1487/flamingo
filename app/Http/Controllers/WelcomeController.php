<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardListResource;
use App\Http\Resources\PartnerSurveyResources;
use App\Models\Project;
use App\Models\Survey;

class WelcomeController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->latest()->take(15)->get();
        $surveys = Survey::orderBy('id', 'desc')->paginate(50);
        $projects = DashboardListResource::collection($projects);
        $surveys = PartnerSurveyResources::collection($surveys);
        return view('welcome', ['projects' => $projects, 'surveys' => $surveys]);
    }
}
