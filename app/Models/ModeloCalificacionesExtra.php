<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloCalificacionesExtra extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'calificaciones_extra';
    // aqui la llave primaria de la tabla
    // protected $primarykey = 'curp';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'curp',
        'clave_grupo',
        'clave_asignatura',
        'calificacion',
        'fecha_aplicacion',
        'rfc_docente',
        'observaciones',
        'rvoe', 'vigencia'
    ];
}
