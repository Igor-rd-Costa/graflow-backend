<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class ProjectController extends Controller
{
    public function create(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user == null) {
            return response(null, 401);
        }

        $values = $request->validate([
            "name" => ['required', 'string']
        ]);

        $values["user_id"] = $user->id;

        $project = Project::create($values);
        return response($project);
    }

    public function infos(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user == null) {
            return response(null, 401);
        }

        $projects = $user->projects()->get();

        return response($projects);
    }

    public function get(Project $project)
    {
        $user = Auth::user();
        if ($user == null) {
            return response(null, 401);
        }
        if ($project->user_id != $user->id) {
            return response(null, 404);
        }
    
        return response($project);
    }

    public function getUpdatedAt(Project $project)
    {
        $user = Auth::user();
        if ($user == null) {
            return response(null, 401);
        }
        if ($project->user_id != $user->id) {
            return response(null, 404);
        }

        return $project->updated_at;
    }
}
