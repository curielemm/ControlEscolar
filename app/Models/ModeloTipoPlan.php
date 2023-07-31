<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloTipoPlan extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'tipo_nivel';
    // aqui la llave primaria de la tabla
      protected $primarykey = 'id_tipo_nivel';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'id_tipo_nivel','nombre_tipo_nivel'];
}