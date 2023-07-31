<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloPlan extends Model
{
  protected $table = 'plan_estudio';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $primarykey = 'rvoe';
  public $timestamps = true;
  protected $fillable = [
    'clave_plan', 'clave_dgp', 'rvoe', 'fecha_rvoe', 'fecha_pub_periodico',
    'nombre_plan', 'id_tipo_nivel', 'id_nivel_educativo',
    'id_modalidad', 'id_opcion_educativa', 'id_duracion',
    'vigencia', 'id_turno', 'descripcion', 'id_status',
    'calif_maxima', 'calif_min', 'calif_aprobatoria', 'intentos','dof'
  ];



  public function scopeRevoe($query, $rvoe)
  {
    if ($rvoe)
      $query->where('rvoe', 'LIKE', "%$rvoe%");
  }

  public function scopeName($query, $nombre)
  {
    if ($nombre)
      $query->where('plan_estudio.nombre_plan', 'LIKE', "%$nombre%");
  }

  public function scopeStatus($query, $id_status)
  {
    if ($id_status)
      $query->where('status.id_status', 'LIKE', "%$id_status%");
  }
}
