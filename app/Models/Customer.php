<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'nombre', 'cedula_rif', 'telefono', 'email',
        'direccion_fiscal', 'notas', 'activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeBuscar($query, ?string $termino)
    {
        if (! $termino) {
            return $query;
        }

        return $query->where(function ($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('cedula_rif', 'like', "%{$termino}%");
        });
    }
}