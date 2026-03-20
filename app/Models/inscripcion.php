<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $fillable = ['usuario_id', 'grupo_id'];

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function grupo()
    {
        return $this->belongsTo(grupo::class);
    }
}
