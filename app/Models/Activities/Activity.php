<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
      'site_id',
      'user_id',
      'type',
      'title',
      'contents',
      'image_url',
      'meta',
    ];

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
