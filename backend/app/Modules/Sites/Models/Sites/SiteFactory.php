<?php

namespace App\Modules\Sites\Models\Sites;


use App\Modules\Sites\Models\Site;
use App\Services\TDCache;
use Illuminate\Database\Eloquent\Builder;

class SiteFactory
{

    const VALID_ECOMMERCE_DOMAINS = [
        'http://localhost:3000',
        'https://localhost:3000',
        'https://marketale.trenchapps.com',
    ];

    private static array $siteCache;

    /**
     * @return AbstractSite|Site|null
     */
    public static function getInstanceOrNull(): null|AbstractSite|Site
    {
        $domain         = get_domain();

        if (isset(self::$siteCache[$domain])) {
            return self::$siteCache[$domain];
        }

        $strippedDomain = $domain;

        if (count($domainParts = explode('.', $domain)) > 2) {
            $strippedDomain = implode('.', array_slice($domainParts, -2, 2, false));
        }

        $query = Site::query()->where(function (Builder $inner) use ($domain, $strippedDomain) {
            // it exactly match the domain
            $inner->where('domain', '=', $domain)
                ->orWhere(function (Builder $inner) use ($strippedDomain) {
                    $inner->where('allow_wildcard_for_domain', 1)
                        ->where('domain', '=', "$strippedDomain");
                });
        });

        /** @var Site $site */
        $site = $query->first();

        if (empty($site) || empty($site->theme)) {
            return null;
        }

        self::$siteCache[$domain] = $site;

        return $site;
    }

}
