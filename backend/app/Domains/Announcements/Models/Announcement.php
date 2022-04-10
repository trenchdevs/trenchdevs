<?php

namespace App\Domains\Announcements\Models;

use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use SiteScoped;

    protected $table = 'announcements';
}
