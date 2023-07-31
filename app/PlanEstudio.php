<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    protected $table = 'plan_estudio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primarykey = 'clave_plan';
    public $timestamps = false;
    protected $fillable = ['clave_plan', 'revoe', 'nombre_plan', 'vigencia', 'no_creditos', 'duracion_ciclo','descripcion'];

}
