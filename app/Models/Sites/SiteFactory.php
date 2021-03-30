<?php

namespace App\Models\Sites;


class SiteFactory {

    const VALID_ECOMMERCE_DOMAINS = [
        'http://localhost:3000',
        'https://localhost:3000',
        'https://marketale.trenchapps.com',
    ];

    /**
     * @return AbstractSite|null
     */
    public static function getInstanceOrNull(): ?AbstractSite{

        if (in_array(request()->header('origin'), self::VALID_ECOMMERCE_DOMAINS)) {
            return new Marketale();
        }

        return null;
    }

}
