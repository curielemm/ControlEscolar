<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloEquivalenciaAlumno extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'equivalencia_alumno';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'clave_equivalencia',
        'fk_curp_alumno', 'revoe_anterior',
        'revoe_actual',
        'fecha_equivalencia', 'matricula_actual', 'matricula_anterior',
        'grado_nivel', 'observaciones'
    ];
}
