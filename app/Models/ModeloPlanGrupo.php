<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloPlanGrupo extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'plan_grupo';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'rvoe', 'clave_grupo', 'vigencia', 'archivo_validacion_inscripcion', 'id_ciclo
        _escolar',
    ];
}
