<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(6);

        return response()->json($projects);
    }

    public function getProject($slug)
    {
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();

        if ($project['image']) {

            $project['image'] = asset('storage/' . $project->image);

        } else {

            $project['image'] = 'https://via.placeholder.com/200x200';

        }

        return response()->json($project);
    }
}
