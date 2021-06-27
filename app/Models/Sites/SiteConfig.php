<?php

namespace App\Models\Sites;

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

    public static function findByKeyName(int $siteId, string $keyName): ?self {
        return self::query()
            ->where('site_id', $siteId)
            ->where('key_name', $keyName)
            ->first();

    }

}
