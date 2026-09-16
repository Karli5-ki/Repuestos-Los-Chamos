<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    protected $fillable = [
        'numero', 'customer_id', 'user_id',
        'fecha_emision', 'fecha_vencimiento',
        'subtotal', 'iva', 'total', 'tasa_bcv',
        'estado', 'observaciones',
    ];

    protected $casts = [
        'fecha_emision'     => 'date',
        'fecha_vencimiento' => 'date',
        'subtotal'          => 'decimal:2',
        'iva'               => 'decimal:2',
        'total'             => 'decimal:2',
        'tasa_bcv'          => 'decimal:4',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    // -------------------- Scopes --------------------

    public function scopeBorradores($query)
    {
        return $query->where('estado', 'borrador');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    public function scopeVencidas($query)
    {
        return $query->where('estado', '!=', 'convertida')
                     ->whereDate('fecha_vencimiento', '<', now());
    }

    // -------------------- Helpers --------------------

    public function estaConvertida(): bool
    {
        return $this->estado === 'convertida';
    }

    public function puedeConvertirseAVenta(): bool
    {
        return in_array($this->estado, ['borrador', 'enviada', 'aprobada']);
    }

    public function totalEnBs(): float
    {
        return round((float) $this->total * (float) $this->tasa_bcv, 2);
    }

    /**
     * Genera el próximo número tipo 0000-0539.
     */
    public static function proximoNumero(): string
    {
        $ultimo = static::orderByDesc('id')->value('numero');

        if (! $ultimo) {
            return '0000-0001';
        }

        [$prefijo, $correlativo] = explode('-', $ultimo);
        $nuevo = str_pad((int) $correlativo + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefijo}-{$nuevo}";
    }
}