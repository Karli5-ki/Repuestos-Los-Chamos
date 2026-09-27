<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeRate extends Model
{
    protected $fillable = ['fecha', 'bcv', 'bina', 'user_id'];

    protected $casts = [
        'fecha' => 'date',
        'bcv'   => 'decimal:4',
        'bina'  => 'decimal:4',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tasa BCV vigente (última registrada hasta hoy).
     */
    public static function actual(): ?self
    {
        return static::where('fecha', '<=', now()->toDateString())
                     ->orderByDesc('fecha')
                     ->first();
    }

    public static function delDia(): ?self
    {
        return static::where('fecha', now()->toDateString())->first();
    }
}
