<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sale extends Model
{
    protected $fillable = [
        'numero_factura', 'customer_id', 'user_id', 'quote_id',
        'fecha',
        'subtotal', 'iva', 'total',
        'tasa_bcv', 'total_bs',
        'tipo_pago', 'monto_pagado_usd', 'monto_pagado_bs',
        'estado', 'motivo_anulacion', 'anulada_por', 'anulada_en',
        'observaciones',
    ];

    protected $casts = [
        'fecha'            => 'date',
        'subtotal'         => 'decimal:2',
        'iva'              => 'decimal:2',
        'total'            => 'decimal:2',
        'tasa_bcv'         => 'decimal:4',
        'total_bs'         => 'decimal:2',
        'monto_pagado_usd' => 'decimal:2',
        'monto_pagado_bs'  => 'decimal:2',
        'anulada_en'       => 'datetime',
    ];

    // -------------------- Relaciones --------------------

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function anuladaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anulada_por');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'referencia');
    }

    // -------------------- Scopes --------------------

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopeAnuladas($query)
    {
        return $query->where('estado', 'anulada');
    }

    public function scopeDelDia($query)
    {
        return $query->whereDate('fecha', now()->toDateString());
    }

    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }

    // -------------------- Helpers --------------------

    public function estaActiva(): bool
    {
        return $this->estado === 'activa';
    }

    public function totalEnBs(): float
    {
        return round((float) $this->total * (float) $this->tasa_bcv, 2);
    }

    /**
     * Genera próximo número de factura tipo 0000-0001.
     */
    public static function proximoNumero(): string
    {
        $ultimo = static::orderByDesc('id')->value('numero_factura');

        if (! $ultimo) {
            return '0000-0001';
        }

        [$prefijo, $correlativo] = explode('-', $ultimo);
        $nuevo = str_pad((int) $correlativo + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefijo}-{$nuevo}";
    }
}