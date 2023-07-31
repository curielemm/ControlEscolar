<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloAluGpoAsig extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'alumno_grupo_asignatura';
    // aqui la llave primaria de la tabla
    // aqui los elementos a mostrarse de la tabla en cuestion
    public $timestamps = false;
    protected $fillable = [
        'curp',
        'clave_grupo',
        'clave_asignatura',
        'rvoe',
        'vigencia',
        'status_aa',
        'pl1',
        'pl2',
        'pl3',
        'pl4',
        'pl5',
        'ordinario',
        'promedio_final',
        'final',
        'porcentaje_asistencia',
        'fpl1',
        'fpl2',
        'fpl3',
        'fpl4',
        'fpl5',
        'fordinario',
    ];
}
