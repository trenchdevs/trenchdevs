<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\AuthWebController;
use App\Models\Projects\Project;

class ProjectsController extends AuthWebController
{
    public function middlewareOnConstructorCalled(): void
    {
        parent::middlewareOnConstructorCalled();
    }

    public function index()
    {
        $projects = Project::query()
            ->where('is_personal', 0)
            ->paginate();

        return view('projects.list', [
            'projects' => $projects,
        ]);
    }
}
