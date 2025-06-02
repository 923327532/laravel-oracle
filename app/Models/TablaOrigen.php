<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaOrigen extends Model
{
    protected $table = 'tabla_origen';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'fecha_creacion',
    ];
}

