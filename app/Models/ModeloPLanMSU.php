<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloPlanMSU extends Model
{
    protected $table = 'plan_estudio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primarykey = 'rvoe';
    public $timestamps = false;
 protected $fillable = ['rvoe', 'fecha_rvoe','fecha_pub_periodico','id_tipo_nivel','id_nivel_educativo','id_modalidad','id_opcion_educativa','id_duracion', 'vigencia', 'id_turno','id_status','calif_maxima','calif_min','calif_aprobatoria'];


    public function scopeRevoe($query, $rvoe)
    {
        if ($rvoe)
            $query->where('rvoe', 'LIKE', "%$rvoe%");
    }

    public function scopeTipo($query, $nivel)
    {
        if ($nivel)
            $query->where('plan_estudio_msu.id_nivel_educativo_msu', 'LIKE', "%$nivel%");
    }

    public function scopeStatus($query, $id_status)
    {
        if ($id_status)
            $query->where('status.id_status', 'LIKE', "%$id_status%");
    }
}
