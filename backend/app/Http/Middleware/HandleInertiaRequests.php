<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {

        if (site() && site()->inertia_theme === 'TrenchDevsAdmin') {
            $this->rootView = 'layouts.inertia.trenchdevs-admin';
        }

        return parent::handle($request, $next);
    }


    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $now = now();
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'error_message' => fn () => $request->session()->get('error_message'),
            ],
            'server' => [
                'time' => [
                    'now' =>  $now,
                    'day_of_week' => $now->format('l'),
                    'date_human' => $now->format('F d, Y'),
                    'time_human' => $now->format('h:i a')
                ]
            ],
            'site' => site(),
        ]);
    }
}
