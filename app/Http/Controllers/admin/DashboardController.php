<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class DashboardController extends Controller
{
    public function index(){
        $projects = Project::count();
        $technologies = Technology::count();
        $types = Type::count();
        return view('admin.home', compact('projects', 'technologies', 'types'));
    }
}
