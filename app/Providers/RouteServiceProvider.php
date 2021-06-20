<?php

namespace App\Providers;

use App\Models\Site;
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

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapWebApiV1Routes();

        $this->mapSiteRoutes();

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

        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('webapi')
            ->group(base_path('routes/webapi.php'));
    }

    private function mapSiteRoutes()
    {
        try {
            if ($site = Site::getInstance()) { // can be null when migrating

                // routes shared for all sites
                $domain = get_domain();
                // Route::middleware('web')->namespace($this->namespace)->domain($domain)->group(base_path('routes/web-shared.php'));

                $siteRoutesPath = "routes/sites/$site->identifier.php";

                if (file_exists(base_path($siteRoutesPath))) {
                    // these routes overrides web-shared routes
                    Route::middleware('web')->namespace($this->namespace)
                        ->domain($domain)
                        ->group(base_path($siteRoutesPath));
                }
            }
        } catch (Exception $exception) {
            // dd($exception->getMessage());
        }
    }
}
