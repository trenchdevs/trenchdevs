<?php

namespace App\Modules\Sites\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class SecurityMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        // $response->headers->set('Strict-Transport-Security', 'max-age=31536001; includeSubDomains; preload');

        return $response;
    }



}
