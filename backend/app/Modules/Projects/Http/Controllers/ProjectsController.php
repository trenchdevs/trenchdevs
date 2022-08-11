<?php

namespace App\Modules\Projects\Http\Controllers;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Modules\Projects\Models\Project;
use Exception;
use Inertia\Response;

class ProjectsController extends Controller
{
    /**
     * @throws Exception
     */
    public function displayProjects(): Response
    {
        return $this->inertiaRender('Projects/ProjectsList', [
            'data' =>  Project::query()
                ->where('is_personal', 0)
                ->simplePaginate(),
        ]);
    }
}
