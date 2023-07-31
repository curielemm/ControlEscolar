<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloTipoDirectivo extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'tipo_directivo';
    // aqui la llave primaria de la tabla
      protected $primarykey = 'id_tipo_directivo';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'id_tipo_directivo','nombre_tipo_directivo'];
}