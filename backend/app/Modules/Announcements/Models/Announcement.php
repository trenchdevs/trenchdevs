<?php

namespace App\Modules\Announcements\Models;

use App\Modules\Sites\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use SiteScoped;

    protected $table = 'announcements';

    protected $fillable = [
        'site_id',
        'user_id',
        'title',
        'message',
        'status',
    ];

}
