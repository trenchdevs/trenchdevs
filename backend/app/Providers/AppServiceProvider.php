<?php

namespace App\Providers;

use App\Domains\Sites\Models\Site;
use App\Domains\Sites\Models\SiteJson;
use App\Domains\Sites\Models\Sites\SiteConfig;
use App\Domains\Sso\Http\Controllers\TdMetadataController;
use App\Domains\Sso\Traits\TdPerformsSingleSignOn;
use CodeGreenCreative\SamlIdp\Http\Controllers\MetadataController;
use CodeGreenCreative\SamlIdp\Traits\PerformsSingleSignOn;
use Illuminate\Foundation\AliasLoader;
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
        $loader = AliasLoader::getInstance();

        // override necessary samlidp classes
        $loader->alias(PerformsSingleSignOn::class, TdPerformsSingleSignOn::class);
        $loader->alias(MetadataController::class, TdMetadataController::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->injectGlobalViewVariables();
        $this->injectSamlIdpConfig();
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

    /**
     * @return void
     */
    private function injectSamlIdpConfig(): void
    {
        if (empty($site = site()) ||
            $site->getConfigValueByKey(SiteConfig::KEY_NAME_SITE_SAMLIDP_ENABLED) != 1 ||
            empty($samlIdpSettings = $site->getSiteJson(SiteJson::KEY_SAMLIDP))) {
            config(['samlidp' => []]);
            return;
        }

        // defaults
        $original = config('samlidp');

        // override the defaults from DB
        config(['samlidp' => array_merge($original, $samlIdpSettings)]);
    }
}
