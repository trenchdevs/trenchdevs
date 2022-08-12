<?php

namespace App\Providers;

use App\Modules\Sites\Models\SiteConfig;
use App\Modules\Sites\Models\SiteJson;
use App\Modules\Sso\Http\Controllers\TdMetadataController;
use App\Modules\Sso\Traits\TdPerformsSingleSignOn;
use CodeGreenCreative\SamlIdp\Http\Controllers\MetadataController;
use CodeGreenCreative\SamlIdp\Traits\PerformsSingleSignOn;
use Illuminate\Foundation\AliasLoader;
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
    public function register(): void
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
    public function boot(): void
    {

        $this->injectGlobalViewVariables();
        $this->injectSamlIdpConfig();
    }

    /**
     * Inject authenticated user to all views if user is logged in
     */
    private function injectGlobalViewVariables(): void
    {

        View::share('site', new stdClass); // set var default to null

        view()->composer('*', function ($view) {

            if (!empty($site = site())) {
                $view->with('site', $site);
            }
        });
    }

    /**
     * @return void
     */
    private function injectSamlIdpConfig(): void
    {
        if (
            empty($site = site()) ||
            $site->getConfigValueByKey(SiteConfig::KEY_NAME_SITE_SAMLIDP_ENABLED) != 1 ||
            empty($samlIdpSettings = $site->getSiteJson(SiteJson::KEY_SAML_IDP))
        ) {
            // don't inject anything, just use default
            return;
        }

        // defaults
        $original = config('samlidp');

        // override the defaults from DB
        config(['samlidp' => array_merge($original, $samlIdpSettings)]);
    }
}
