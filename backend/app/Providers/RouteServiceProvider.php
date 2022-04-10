<?php

namespace App\Providers;

use App\Domains\Sites\Models\Site;
use App\Domains\Users\Models\User;
use Exception;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/portal/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebApiV1Routes();

        if (!app()->runningInConsole()) {
            // we don't need site specific routes on console
            // e.g. when doing php artisan route:list
            // site instance is not available
            $this->mapSiteRoutes();
        }

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        // $this->mapWebApiV1Routes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }


    protected function mapWebApiV1Routes()
    {

        $this->__inject_local_credentials();

        if (!empty($site = Site::getInstance()) && $site->theme == 'sjp') {

            Route::middleware(['web', 'webapi'])
                ->namespace($this->namespace)
                ->prefix('webapi')
                ->group(base_path('routes/webapi.php'));
        }

    }

//    private function mapSiteRoutesOld()
//    {
//        try {
//            $sites = Site::query()->whereNotNull('theme')->get();
//
//            foreach ($sites as $site) {
//
//            // routes shared for all sites
//            // $domain = get_domain();
//            // Route::middleware('web')->namespace($this->namespace)->domain($domain)->group(base_path('routes/web-shared.php'));
//
//            $siteRoutesPath = "routes/themes/$site->theme.php";
//
//            if (!file_exists(base_path($siteRoutesPath))) {
//                continue;
//            }
//
//            // these routes overrides web-shared routes
//            Route::middleware('web')->namespace($this->namespace)
//                ->domain($site->domain)
//                ->group(base_path($siteRoutesPath));
//
//            }
//
//        } catch (Exception $exception) {
//            // dd($exception->getMessage());
//        }
//    }

    private function mapSiteRoutes()
    {
        try {
            $site           = site();
            $siteRoutesPath = "routes/themes/$site->theme.php";

            if (!file_exists(base_path($siteRoutesPath))) {
                throw new Exception("$siteRoutesPath not found");
            }

            Route::middleware('web')->namespace($this->namespace)
                ->domain($site->domain)
                ->group(base_path($siteRoutesPath));

        } catch (Exception $exception) {
            if (app()->environment('local')) {
                dd($exception->getMessage());
            }
        }
    }

    private function __inject_local_credentials()
    {
        // Ensure we only do this on the react app
        if (app()->environment('local') && request()->server('HTTP_ORIGIN') === 'http://localhost:3000') {
            /** @var User $user */
            $user = User::query()->withoutGlobalScopes()->findOrFail(21);
            auth('web')->login($user);
            Site::setSiteInstance($user->site);
        }
    }
}
