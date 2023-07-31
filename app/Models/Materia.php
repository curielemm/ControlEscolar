<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'asignatura';
    // aqui la llave primaria de la tabla
    protected $primarykey = 'clave_asignatura';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'clave_asignatura','no_creditos','nombre_asignatura','seriazion','fk_rvoe','semestre_cuatrimestre','no_periodo','tipo_asignatura','clave_seriacion','no_parciales'];
}
