<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdminWhitelistedIp extends Model
{
    protected $table = 'superadmin_whitelisted_ips';

    /**
     * @param int $userId
     * @param string $ip
     * @return bool
     */
    public static function isWhitelisted(int $userId, string $ip)
    {
        return self::query()
                ->where('ip', $ip)
                ->where('user_id', $userId)
                ->count() > 0;
    }
}
