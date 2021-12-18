<?php

namespace App\Domains\TrenchDevs\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\TrenchDevs\Repositories\AdminDashboardMetrics;
use App\Domains\Users\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param AdminDashboardMetrics $dashboardMetrics
     * @return Renderable
     */
    public function index(Request  $request, AdminDashboardMetrics $dashboardMetrics): Renderable
    {

        /** @var User $user */
        $user = $request->user();

        return view('home', [
            'user' => $user,
            'portfolio_details' => $user->getPortfolioDetails(),
            'dashboard_metrics' => $dashboardMetrics,
        ]);
    }
}
