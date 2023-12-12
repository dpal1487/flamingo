<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectListResource;
use App\Models\Projects;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = Projects::orderBy('id', 'desc')->get();

        return ProjectListResource::collection($data);

        return view('welcome', $data);
    }
}
