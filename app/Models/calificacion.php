<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calificacion extends Model
{
    protected $table = 'calificacions';

    protected $fillable = [
        'usuario_id',
        'grupo_id',
        'calificacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function grupo()
    {
        return $this->belongsTo(grupo::class);
    }
}
