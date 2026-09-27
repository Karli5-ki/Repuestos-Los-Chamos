<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Purchase extends Model
{
    protected $fillable = [
        'numero_factura', 'supplier_id', 'user_id',
        'fecha', 'subtotal', 'iva', 'total',
        'estado', 'motivo_anulacion', 'anulada_por', 'anulada_en',
        'observaciones',
    ];

    protected $casts = [
        'fecha'       => 'date',
        'subtotal'    => 'decimal:2',
        'iva'         => 'decimal:2',
        'total'       => 'decimal:2',
        'anulada_en'  => 'datetime',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anuladaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anulada_por');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'referencia');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function estaActiva(): bool
    {
        return $this->estado === 'activa';
    }
}