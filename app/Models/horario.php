<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'materia_id',
        'maestro_id',
        'hora_inicio',
        'hora_fin',
        'dias',
    ];

    public function materia()
    {
        return $this->belongsTo(materia::class);
    }

    public function maestro()
    {
        return $this->belongsTo(usuario::class, 'maestro_id');
    }
}
