<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloAsignaturaSeriacion extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'asignatura_seriacion';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'clave_asignatura',
        'clave_seriacion',
        'rvoe',
        'vigencia'
    ];
}
