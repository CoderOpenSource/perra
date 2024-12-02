<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoliActivo extends Model
{
    use HasFactory;

    protected $table = 'soli_activo';

    protected $fillable = [
        'item',
        'unidad',
        'cantidad',
        'id_sol', // Relación con solicitud
    ];

    // Relación con el modelo Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_sol');
    }
}
