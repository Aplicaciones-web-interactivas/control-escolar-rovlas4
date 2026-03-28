<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tarea extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'grupo_id', 'usuario_id', 'fecha_entrega'];

    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];

    public function grupo()
    {
        return $this->belongsTo(grupo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function entregas()
    {
        return $this->hasMany(entrega_tarea::class);
    }
}
