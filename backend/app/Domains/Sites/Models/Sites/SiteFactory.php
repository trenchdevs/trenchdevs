<?php

namespace App\Domains\Sites\Models\Sites;


use App\Domains\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;

class SiteFactory
{

    const VALID_ECOMMERCE_DOMAINS = [
        'http://localhost:3000',
        'https://localhost:3000',
        'https://marketale.trenchapps.com',
    ];

    /**
     * @return AbstractSite|Site|RentalSite|null
     */
    public static function getInstanceOrNull(): null|AbstractSite|Site|RentalSite
    {
        if (in_array(request()->header('origin'), self::VALID_ECOMMERCE_DOMAINS)) {
            return new Marketale();
        }

        $domain         = get_domain();
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
        // td_echo_builder_query($query);

        /** @var Site $site */
        $site = $query->first();

        if (empty($site) || empty($site->theme)) {
            return null;
        }

        if ($site->theme === 'rental') {
            $site = RentalSite::query()->findOrFail($site->id);
        }

        return $site;
    }

}
