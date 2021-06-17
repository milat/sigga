<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

abstract class CacheService
{
    /**
     *  Returns Cache instance
     *
     *  @param string $tag
     *
     *  @return Cache
     */
    public static function get(string $tag = null)
    {
        $cache = Cache::store('redis');

        if ($tag) {
            $cache->tags(self::key($tag));
        }

        return $cache;
    }

    /**
     *  Deletes caches by tag
     *
     *  @param string $tag
     * 
     *  @return void
     */
    public static function flush(string $tag)
    {
        self::get($tag)->flush();
    }

    /**
     *  Deletes cache by key
     *
     *  @param string $key
     *
     *  @return void
     */
    public static function forget(string $key)
    {
        self::get()->forget($key);
    }

    /**
     *  Returns key
     *
     *  @return string
     */
    public static function key()
    {
        $prefix = "office_".Auth::user()->office_id."_";
        $key = implode("_", func_get_args());
        return $prefix.$key;
    }
}
