<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupo extends Model
{
    protected $fillable = ['nombre', 'horario_id'];

    public function horario()
    {
        return $this->belongsTo(horario::class);
    }
}
