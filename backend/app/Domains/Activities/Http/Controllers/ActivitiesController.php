<?php

namespace App\Domains\Activities\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Activities\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{

    public function store(Request $request) {

        $data = $request->all();
        $data['site_id'] = $this->site->id;
        Activity::query()->create($data);
        return $this->jsonResponse('success', 'Success');
    }

}
