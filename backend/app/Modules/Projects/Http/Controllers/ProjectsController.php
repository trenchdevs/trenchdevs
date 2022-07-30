<?php

namespace App\Modules\Projects\Http\Controllers;

use App\Http\Controllers\AuthWebController;
use App\Modules\Projects\Models\Project;

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
            ->simplePaginate();

        return view('projects.list', [
            'projects' => $projects,
        ]);
    }
}
