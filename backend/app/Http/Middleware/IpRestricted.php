<?php

namespace App\Http\Middleware;

use App\Modules\Sites\Models\Site;
use Closure;
use Illuminate\Http\Request;

class IpRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {

        if (
            !empty($ips = site()->getWhitelistedIps())
            &&
            !in_array($request->ip(), $ips)
        ) {
            // ip is not whitelisted
            abort(403);
        }

        return $next($request);
    }
}
