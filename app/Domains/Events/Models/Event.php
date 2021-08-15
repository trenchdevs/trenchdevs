<?php

namespace App\Domains\Events\Models;

use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use SiteScoped;

    protected $table = 'events';

}
