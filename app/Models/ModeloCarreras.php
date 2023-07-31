<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloCarrera extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'carrera';
    // aqui la llave primaria de la tabla
    protected $primarykey = 'id_carrera';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'id_carrera','no_revoe','clave_cct','nombre'];
}
