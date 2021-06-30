<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activities\Activity;
use Illuminate\Http\Request;

class ApiActivities extends Controller
{

    public function store(Request $request) {

        $data = $request->all();
        $data['site_id'] = $this->site->id;
        Activity::query()->create($data);
        return $this->jsonResponse('success', 'Success');
    }

}
