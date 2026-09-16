<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'username', 'email', 'password',
        'cedula', 'telefono', 'activo', 'ultimo_acceso',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'ultimo_acceso'     => 'datetime',
            'password'          => 'hashed',
            'activo'            => 'boolean',
        ];
    }

    // -------------------- Relaciones --------------------

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // -------------------- Scopes --------------------

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // -------------------- Helpers de rol --------------------

    public function esAdministrador(): bool
    {
        return $this->hasRole('administrador');
    }

    public function esAlmacen(): bool
    {
        return $this->hasRole('almacen');
    }

    public function esCajero(): bool
    {
        return $this->hasRole('cajero');
    }

    public function puedeGestionarUsuarios(): bool
    {
        return $this->esAdministrador();
    }

    public function puedeGestionarInventario(): bool
    {
        return $this->esAdministrador() || $this->esAlmacen();
    }

    public function puedeVender(): bool
    {
        return $this->esAdministrador() || $this->esCajero();
    }
}