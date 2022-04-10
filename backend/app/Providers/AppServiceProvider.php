<?php

namespace App\Providers;

use App\Domains\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            if ($site && $site->theme === 'growingbokchoy') {
                $view->with('tags', $tags = DB::select(DB::raw("
                    SELECT t.id, tag_name
                    FROM tags t
                    INNER JOIN blog_tags bt ON t.id = bt.tag_id
                    INNER JOIN blogs b ON bt.blog_id = b.id
                    WHERE b.site_id = {$site->id}
                ")));
            }

        });
    }
}
