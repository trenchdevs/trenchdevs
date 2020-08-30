<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteBlacklistedIp extends Model
{
    protected $table = 'site_blacklisted_ips';

    /**
     * @param string $ip
     * @return bool
     */
    public static function isBlackListed(string $ip)
    {
        return self::query()
                ->where('ip', $ip)
                ->count() > 0;
    }
}
