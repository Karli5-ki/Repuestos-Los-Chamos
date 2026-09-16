<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo', 'descripcion',
        'brand_id', 'unit_id', 'category_id',
        'precio_compra', 'margen_porcentaje', 'precio_venta', 'aplica_iva',
        'stock', 'stock_minimo',
        'activo', 'observaciones',
    ];

    protected $casts = [
        'precio_compra'     => 'decimal:2',
        'margen_porcentaje' => 'decimal:2',
        'precio_venta'      => 'decimal:2',
        'aplica_iva'        => 'boolean',
        'stock'             => 'integer',
        'stock_minimo'      => 'integer',
        'activo'            => 'boolean',
    ];

    // -------------------- Relaciones --------------------

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
                    ->withPivot(['codigo_supplier', 'precio_supplier', 'preferido'])
                    ->withTimestamps();
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function quoteItems(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // -------------------- Scopes --------------------

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeStockBajo($query)
    {
        return $query->whereColumn('stock', '<=', 'stock_minimo')
                     ->where('stock_minimo', '>', 0);
    }

    public function scopeSinStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeBuscar($query, ?string $termino)
    {
        if (! $termino) {
            return $query;
        }

        return $query->where(function ($q) use ($termino) {
            $q->where('codigo', 'like', "%{$termino}%")
              ->orWhere('descripcion', 'like', "%{$termino}%");
        });
    }

    // -------------------- Accessors --------------------

    public function getEstaSinStockAttribute(): bool
    {
        return $this->stock <= 0;
    }

    public function getEstaStockBajoAttribute(): bool
    {
        return $this->stock_minimo > 0 && $this->stock <= $this->stock_minimo;
    }

    /**
     * Precio de venta calculado (sin IVA).
     */
    public function getPrecioVentaCalculadoAttribute(): float
    {
        return round(
            (float) $this->precio_compra * (1 + (float) $this->margen_porcentaje / 100),
            2
        );
    }

    /**
     * Precio de venta con IVA si aplica.
     */
    public function getPrecioVentaConIvaAttribute(): float
    {
        $precio = (float) $this->precio_venta;

        if (! $this->aplica_iva) {
            return $precio;
        }

        $iva = (float) Setting::get('iva', 16) / 100;

        return round($precio * (1 + $iva), 2);
    }
}