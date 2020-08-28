<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request  $request)
    {

        /** @var User $user */
        $user = $request->user();

        return view('home', [
            'user' => $user,
            'portfolio_details' => $user->getPortfolioDetails(),
        ]);
    }
}
