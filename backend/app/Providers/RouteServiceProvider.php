<?php

namespace App\Providers;

use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
use App\Services\TDCache;
use Exception;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        // shared api routes
        $this->mapApiRoutes();

        // shared web routes
        $this->mapWebRoutes();

        // map site specific routes
        $this->mapSiteRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
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
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }


    private function mapSiteRoutes()
    {

        try {

            /** @var Site[] $sites */
            $sites = Site::all();

            foreach ($sites as $site) {

                if (empty($site)) {
                    throw new Exception("Site not found.");
                }

                if (empty($site->theme)) {
                    throw new Exception("Site theme not found");
                }

                $siteRoutesPath = "routes/themes/$site->theme.php";

                if (!file_exists(base_path($siteRoutesPath))) {
                    throw new Exception("$siteRoutesPath not found");
                }

                Route::namespace($this->namespace)
                    ->domain($site->domain)
                    ->as("$site->identifier.")
                    ->group(base_path($siteRoutesPath));

            }
        } catch (Exception $exception) {
            // ignore
        }

    }

}
