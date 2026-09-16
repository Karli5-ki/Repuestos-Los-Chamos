<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id', 'user_id',
        'tipo', 'cantidad',
        'stock_anterior', 'stock_nuevo',
        'motivo',
        'referencia_type', 'referencia_id',
        'observaciones',
    ];

    protected $casts = [
        'cantidad'       => 'integer',
        'stock_anterior' => 'integer',
        'stock_nuevo'    => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referencia(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    public function scopeSalidas($query)
    {
        return $query->where('tipo', 'salida');
    }

    public function scopeDelProducto($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }
}