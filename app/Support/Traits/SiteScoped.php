<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SiteScoped {

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(function (Builder $builder) {

            // add a constraint for only users under the current site
            if ($site = site()) {
                $builder->where('site_id', $site->id);
            }
        });
    }

}
