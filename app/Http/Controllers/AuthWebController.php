<?php

namespace App\Http\Controllers;

use App\Domains\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class AuthWebController extends Controller
{
    /** @var User */
    protected $user;

    /**
     * AuthWebController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->middlewareOnConstructorCalled();
            return $next($request);
        });
        parent::__construct();
    }


    public function middlewareOnConstructorCalled(): void {
        // do custom logic per controller
    }
}
