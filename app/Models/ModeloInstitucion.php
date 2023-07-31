<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloInstitucion extends Model
{
  //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'institucion';
  // aqui la llave primaria de la tabla
  protected $primarykey = 'clave_cct';

  public $timestamps = true;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'clave_cct', 'clave_dgpi', 'nombre_institucion', 'municipio',
    'codigo_postal', 'colonia', 'calle', 'numero_interior', 'numero_exterior', 'directivo_autorizado', 'periodico_oficial', 'pagina_web', 'id_tipo_directivo','id_tipo_institucion'];

  public function scopeName($query, $nombre)
  {
    if ($nombre)
      $query->where('nombre_institucion', 'LIKE', "%$nombre%");
  }

  public function scopeCct($query, $cct)
  {
    if ($cct)
      $query->where('institucion.clave_cct', 'LIKE', "%$cct%");
  }
}
