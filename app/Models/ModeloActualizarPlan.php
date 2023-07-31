<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloActualizarPlan extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'actualizacion_plan';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'rvoe', 'clave_plan', 'id_tipo_nivel', 
        'nombre_plan', '', 'id_nivel_educativo',
        'id_modalidad', 'id_opcion_educativa', 'id_duracion',
        'vigencia', 'id_turno', 'descripcion', 'id_status',
        'calif_maxima', 'calif_min', 'calif_aprobatoria', 'intentos','archivo'
    ];
}
