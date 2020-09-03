<?php

namespace App\Http\Middleware;

use App\Models\SiteAccessLog;
use App\Models\SiteBlacklistedIp;
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
        $ip = $request->ip();

        $isBlackListed = SiteBlacklistedIp::isBlackListed($ip);

        $miscArr = [
            'request_encoded' => base64_encode(json_encode($request->all())),
            'headers' => $request->headers,
        ];

        $requestData = $request->all();
        $userAgent = $request->header('User-Agent');

        if ($userAgent === 'ELB-HealthChecker/2.0') {
            /**
             * Do not log elb health checks
             */
            return $next($request);
        }

        if (!empty($requestData)) {
            $miscArr['request_encoded'] = base64_encode(json_encode($requestData));
        }

        $headers = collect($request->header())->transform(function ($item) {
            return $item[0];
        });

        if (!empty($headers)) {
            $miscArr['headers'] = $headers;
        }

        $method = $request->method();

        if (!empty($method)) {
            $miscArr['method'] = $method;
        }


        $siteAccess = new SiteAccessLog();

        $data = [
            'user_id' => $user->id ?? null,
            'url' => $request->fullUrl(),
            'ip' => $ip,
            'user_agent' => $userAgent,
            'referer' => $request->header('referer'),
        ];

        if (!empty($miscArr)) {
            $data['misc_json'] = json_encode($miscArr);
        }

        if ($isBlackListed) {
            $data['action'] = SiteAccessLog::DB_ACTION_DENIED;
        } else {
            $data['action'] = SiteAccessLog::DB_ACTION_ALLOWED;
        }

        $siteAccess->fill($data);
        $siteAccess->save();

        if ($isBlackListed) {
            abort(403);
        }

        return $next($request);
    }
}
