<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'tipo', 'descripcion'];

    /**
     * Obtener valor con cache. Se invalida al guardar.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::rememberForever("setting.{$key}", function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (! $setting) {
            return $default;
        }

        return match ($setting->tipo) {
            'int'     => (int) $setting->value,
            'decimal' => (float) $setting->value,
            'bool'    => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }

    public static function set(string $key, mixed $value, string $tipo = 'string', ?string $descripcion = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value'       => is_array($value) ? json_encode($value) : (string) $value,
                'tipo'        => $tipo,
                'descripcion' => $descripcion,
            ]
        );

        Cache::forget("setting.{$key}");
    }

    protected static function booted(): void
    {
        static::saved(fn ($setting) => Cache::forget("setting.{$setting->key}"));
        static::deleted(fn ($setting) => Cache::forget("setting.{$setting->key}"));
    }
}