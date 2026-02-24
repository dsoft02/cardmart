<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    protected static function cacheKey(string $key): string
    {
        return "settings.$key";
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever(
            self::cacheKey($key),
            fn() => static::query()
                ->where('key', $key)
                ->value('value') ?? $default
        );
    }

    public static function set(string $key, mixed $value): void
    {
        Cache::forget(self::cacheKey($key));

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
