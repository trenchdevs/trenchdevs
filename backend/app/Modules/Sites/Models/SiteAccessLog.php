<?php

namespace App\Modules\Sites\Models;

use Illuminate\Database\Eloquent\Model;

class SiteAccessLog extends Model
{
    protected $table = 'site_access_logs';

    const DB_ACTION_ALLOWED = 'allowed';
    const DB_ACTION_DENIED = 'denied';

    protected $fillable = [
        'user_id',
        'url',
        'ip',
        'user_agent',
        'referer',
        'misc_json',
        'action',
    ];

}
