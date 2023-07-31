<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloPlanCPT extends Model
{
   protected $table = 'plan_estudio_cpt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $primarykey = 'clave_plan';
    public $timestamps = false;
    protected $fillable = ['rvoe_cpt', 'fecha_rvoe','fecha_pub_periodico','tipo','id_nivel_educativo_cpt','id_modalidad','id_opcion_educativa_cpt','id_duracion', 'vigencia', 'id_turno','status_institucion'];
}
