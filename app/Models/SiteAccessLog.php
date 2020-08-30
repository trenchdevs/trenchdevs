<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteAccessLog extends Model
{
    protected $table = 'site_access_logs';

    protected $fillable = [
        'user_id',
        'url',
        'ip',
        'user_agent',
        'referer',
        'misc_json',
    ];

}
