<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloDocente extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'docente';
    // aqui la llave primaria de la tabla
    protected $primarykey = 'rfc';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'rfc','nombre','apellido_paterno','apellido_materno',
      'telefono','correo','fk_clave_cct'];
}
