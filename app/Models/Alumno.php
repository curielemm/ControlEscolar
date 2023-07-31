<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
  //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'alumno';
  // aqui la llave primaria de la tabla
  protected $primarykey = 'curp';
  public $timestamps = false;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'curp',
    'nombre',
    'apellido_paterno',
    'apellido_materno',
    'sexo',
    'correo',
    'telefono',
    'status_inscripcion'
  ];
}
