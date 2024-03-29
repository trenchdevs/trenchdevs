<?php

namespace App\Modules\Activities\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Activities\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{

    public function store(Request $request): JsonResponse
    {

        $data = $request->all();
        $data['site_id'] = $this->site->id;
        ActivityLog::query()->create($data);
        return $this->jsonResponse('success', 'Success');
    }

}
