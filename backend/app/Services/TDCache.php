<?php

namespace App\Services;

use Closure;
use DateInterval;
use DateTimeInterface;
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
        return !app()->runningInConsole() && (app_config('TD_CACHE_BUST') == 1);
    }


}
