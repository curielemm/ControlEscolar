<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloPlanAsig extends Model
{
  //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'plan_asignatura';
  // aqui la llave primaria de la tabla
  public $timestamps = false;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'rvoe', 'clave_asignatura', 'fecha_actualizacion'
  ];
}
