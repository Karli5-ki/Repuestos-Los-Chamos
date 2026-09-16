<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'nombre', 'contacto', 'telefono', 'email',
        'direccion', 'notas', 'activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
                    ->withPivot(['codigo_supplier', 'precio_supplier', 'preferido'])
                    ->withTimestamps();
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}