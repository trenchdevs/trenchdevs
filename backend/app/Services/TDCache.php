<?php

namespace App\Services;

use Closure;
use DateInterval;
use DateTimeInterface;
use Exception;
use Illuminate\Support\Facades\Cache;

class TDCache
{
    /**
     * @param string $key
     * @param DateTimeInterface|int|DateInterval $ttl
     * @param Closure $callback
     * @return mixed
     */
    public static function remember(string $key, DateTimeInterface|DateInterval|int $ttl, Closure $callback): mixed
    {

        if (self::bust()) {
            Cache::forget($key);
            return $callback();
        }

        return Cache::remember($key, $ttl, $callback);
    }


    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {

        if (self::bust()) {
            Cache::forget($key);
            return $default;
        }

        return Cache::get($key, $default);
    }

    private static function bust(): bool
    {
        try {
            return app_config('CLEAR_CACHE') == 1;
        }catch (Exception) {
            // ignore
        }

        return true;
    }


}
