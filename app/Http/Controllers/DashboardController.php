<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blogs;
use App\Blogcategories;
class DashboardController extends Controller
{
    public function index()
    {
    	return view('dashboard.index');
    }
}
