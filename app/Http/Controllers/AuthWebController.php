<?php

namespace App\Http\Controllers;

use App\User;
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
            $this->middlewareOnConstructorCalled($this->user);
            return $next($request);
        });
    }


    public function middlewareOnConstructorCalled(): void {
        // do custom logic per controller
    }
}
