<?php

namespace App\Http\Controllers;

use App\Models\Projects\Project;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {

        $projects = Project::getGlobalProjects();

        return view('welcome', [
            'projects' => $projects,
        ]);
    }

}
