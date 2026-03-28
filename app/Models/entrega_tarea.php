<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entrega_tarea extends Model
{
    protected $fillable = ['tarea_id', 'usuario_id', 'archivo', 'fecha_entrega'];

    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];

    public function tarea()
    {
        return $this->belongsTo(tarea::class);
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }
}
