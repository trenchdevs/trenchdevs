<?php

namespace App\Http\Middleware;

use App\Models\SiteAccessLog;
use Closure;

class SiteAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();

        $siteAccess = new SiteAccessLog();
        $siteAccess->fill([
            'user_id' => $user->id ?? null,
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('referer'),
            'misc_json' => json_encode([
                'request_encoded' => base64_encode(json_encode($request->all())),
                'headers' => $request->headers,
            ]),
        ]);
        $siteAccess->save();

        return $next($request);
    }
}
