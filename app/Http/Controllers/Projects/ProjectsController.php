<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Models\Projects\Project;
use Illuminate\Http\Request;

class ProjectsController extends AuthWebController
{
    public function middlewareOnConstructorCalled(): void
    {
        parent::middlewareOnConstructorCalled();
        $this->adminCheckOrAbort();
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
