<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'clave_institucional',
        'contraseña',
        'rol',
        'activo',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    // Mapear el campo de contraseña
    public function getAuthPasswordAttribute()
    {
        return $this->contraseña;
    }
}
