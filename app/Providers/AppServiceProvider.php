<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        $this->injectLoggedInUserToViews();

    }

    /**
     * Inject authenticated user to all views if user is logged in
     */
    private function injectLoggedInUserToViews(): void
    {

        View::share('loggedInUser', null); // set var default to null

        view()->composer('*', function ($view) {

            $loggedInUser = Auth::guard('web')->user();

            if ($loggedInUser) {
                $view->with('loggedInUser', $loggedInUser);
            }

        });
    }
}
