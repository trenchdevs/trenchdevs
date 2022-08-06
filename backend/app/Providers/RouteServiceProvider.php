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
    public function boot()
    {
        //

        parent::boot();
    }

    public function register()
    {
        $this->booted(function () {
            $this->setRootControllerNamespace();

            $cacheKey = $this->getCacheKey();

            if (!empty($rawRoutes = TDCache::get($cacheKey))) {
                Log::info('reading from cache');
                eval($rawRoutes);
            } else {
                $this->loadRoutes();

                $this->app->booted(function () {
                    $this->app['router']->getRoutes()->refreshNameLookups();
                    $this->app['router']->getRoutes()->refreshActionLookups();
                });

                // td -- caching -- start
                Log::info('caching');

                /** @var RouteCollection $routes */
                $routes = Route::getRoutes();

                if (count($routes) > 0) {

                    foreach ($routes as $route) {
                        $route->prepareForSerialization();
                    }

                    $stub = file_get_contents(module_path('Routing/stubs/routes.stub'));
                    $raw = str_replace('{{routes}}', var_export($routes->compile(), true), $stub);
                    $raw = str_replace('<?php', '', $raw);
                    eval($raw);
                    Cache::put($cacheKey, $raw, 60 * 5);
                }
                // td -- caching -- end
            }
        });
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

    private function mapSiteRoutes()
    {
        try {

            if (empty($site = site()) || empty($site->theme)) {
                throw new Exception("Theme not found on site");
            }

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

    private function getCacheKey(): string
    {
        return sprintf('%s::%s', static::class, site_id());
    }
}
