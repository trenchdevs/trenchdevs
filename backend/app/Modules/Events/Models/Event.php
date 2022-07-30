<?php

namespace App\Modules\Events\Models;

use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use SiteScoped;

    protected $table = 'events';

    protected $fillable = [
        'site_id',
        'name',
        'description',
        'location',
        'from_date',
        'to_date',
    ];

}
