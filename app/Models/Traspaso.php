<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    use HasFactory;

    protected $table = 'traspasos';

    protected $fillable = [
        'anterior',
        'nuevo',
        'fecha',
        'descripcion',
        'id_activo',
    ];

    /**
     * Relación con el modelo Activo
     */
    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo');
    }
}
