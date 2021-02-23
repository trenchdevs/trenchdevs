<?php

namespace App\Http\Controllers\HighStorage;

use App\Http\Controllers\Controller;
use App\Models\SiteAccessLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMetricsController extends Controller
{
    public function index(Request $request)
    {

        $now = Carbon::now();

        if (!$username = $request->input('username')) {
            return response()->json(['errors' => 'username parameter is required']);
        }

        $url = "https://trenchdevs.org/$username";

        $response = [
            'username' => $username,
            'url' => $url,
            '30 days' => SiteAccessLog::query()->where('url', $url)->where('created_at','>=' ,$now->subMonth())->count(),
            'total' => SiteAccessLog::query()->where('url', $url)->count(),
        ];

        return response()->json($response);
    }
}
