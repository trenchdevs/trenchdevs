<?php

namespace App\Providers;

use App\Domains\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use stdClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->injectGlobalViewVariables();

    }

    /**
     * Inject authenticated user to all views if user is logged in
     */
    private function injectGlobalViewVariables(): void
    {

        View::share('loggedInUser', null); // set var default to null
        View::share('site', new stdClass); // set var default to null

        view()->composer('*', function ($view) {

            if ($loggedInUser = Auth::guard('web')->user()) {
                $view->with('loggedInUser', $loggedInUser);
            }

            if ($site = Site::getInstance()) {
                $view->with('site', $site);
            }

        });
    }
}
