<?php

namespace App\Http\Middleware;

use App\Modules\Sites\Models\SiteAccessLog;
use App\Modules\Sites\Models\SiteBlacklistedIp;
use Closure;
use Exception;
use Illuminate\Http\Request;

class SiteAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user('web');
        $ip = $request->ip();

        $isBlackListed = SiteBlacklistedIp::isBlackListed($ip);

        $miscArr = [
            'headers' => $request->headers,
        ];

        $requestData = $request->all();
        $userAgent   = $request->header('User-Agent');

        if ($userAgent === 'ELB-HealthChecker/2.0') {
            /**
             * Do not log elb health checks
             */
            return $next($request);
        }

        if (!empty($requestData)) {
            unset($requestData['password'], $requestData['password_confirmation']);
            $miscArr['request_encoded'] = $requestData;
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

        $fullUrl = $request->fullUrl();

        $miscArr['full_url'] = $fullUrl;

        $data = [
            'user_id'    => $user->id ?? null,
            'url'        => substr($fullUrl, 0, 500),
            'ip'         => $ip,
            'user_agent' => $userAgent,
            'referer'    => substr($request->header('referer'), 0, 250),
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
