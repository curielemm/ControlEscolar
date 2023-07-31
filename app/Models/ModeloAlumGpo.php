<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloAlumGpo extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'alumno_grupo';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = ['curp','clave_grupo', 'rvoe'];
}