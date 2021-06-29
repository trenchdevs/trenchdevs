<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activities\Activity;
use Illuminate\Http\Request;

class ApiActivities extends Controller
{

    public function store(Request $request) {
        Activity::query()->create(array_merge(
            $request->all(),
            ['site_id' => $this->site->id]
        ));
        return $this->jsonResponse('success', 'Success');
    }

}
