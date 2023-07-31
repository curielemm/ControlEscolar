<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    //
    protected $table = 'institucion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primarykey = 'id';
    public $timestamps = false;
    protected $fillable = ['clave_cct', 'nombre', 'reglamento', 'plan_estudio', 'no_inscripcion', 'fecha_inscripcion'];
}
