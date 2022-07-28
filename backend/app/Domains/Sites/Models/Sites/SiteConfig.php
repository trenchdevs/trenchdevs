<?php

namespace App\Domains\Sites\Models\Sites;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'site_id',
        'key_name',
        'key_value',
        'comments',
    ];

    const KEY_NAME_SYSTEM_LOGIN_REDIRECT_PATH = 'SYSTEM__LOGIN_REDIRECT_PATH';
    const KEY_NAME_SITE_WHITELISTED_IPS = 'SITE_WHITELISTED_IPS'; // json arr

    const KEY_NAME_SITE_SAMLIDP_ENABLED = 'samlidp::enabled';     // json object

    /**
     * @param int $siteId
     * @param string $keyName
     *
     * @return self|null
     */
    public static function findByKeyName(int $siteId, string $keyName): ?self
    {
        /** @var self $config */
        $config = self::query()
            ->where('site_id', $siteId)
            ->where('key_name', $keyName)
            ->first();

        return $config;

    }

}
