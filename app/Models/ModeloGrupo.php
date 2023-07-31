<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloGrupo extends Model
{
  //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'grupo';
  // aqui la llave primaria de la tabla
  protected $primarykey = 'clave_grupo';
  public $timestamps = false;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'clave_grupo', 'nombre_grupo', 'no_semestre', 'no_periodo', 'periodo_escolar', 'clave_docente', 'clave_asignatura',
    'id_turno', 'fk_rvoe', 'fk_clave_ciclo_escolar', 'fecha_ini', 'fecha_fin'
  ];

  public function scopeCiclo($query, $ciclo)
  {
    if ($ciclo)
      $query->where('fk_clave_ciclo_escolar', '=', $ciclo);
  }
}
