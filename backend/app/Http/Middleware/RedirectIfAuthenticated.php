<?php

namespace App\Http\Middleware;

use App\Modules\Sites\Models\Site;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        if (Auth::guard($guard)->check()) {

            if (!empty($site = Site::getInstance()) && !empty($redirectPath = $site->getRedirectPath())) {
                return redirect($redirectPath);
            }

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
