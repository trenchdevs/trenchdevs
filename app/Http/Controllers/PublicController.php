<?php

namespace App\Http\Controllers;

use App\Models\Projects\Project;
use App\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {

        $projects = Project::getGlobalProjects();
        $coreDevs = User::query()
            ->whereIn('id', [2, 3, 4, 11])
            ->get();

        return view('welcome', [
            'projects' => $projects,
            'coreDevs' => $coreDevs,
        ]);
    }

}
