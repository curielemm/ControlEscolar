<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloMSU extends Model
{
  //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'media_superior';
  // aqui la llave primaria de la tabla
  protected $primarykey = 'clave_cct_msu';

  public $timestamps = true;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'clave_cct_msu', 'nombre_institucion_msu', 'municipio',
    'codigo_postal', 'colonia', 'calle', 'numero_interior', 'numero_exterior', 'nombre_directivo', 'reglamento_institucional', 'manual_organizacion', 'pagina_web', 'id_tipo_directivo'
  ];

}
