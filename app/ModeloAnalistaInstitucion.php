<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloAnalistaInstitucion extends Model
{
    //
    protected $table = 'analista_institucion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $primarykey = 'id';
    //public $timestamps = false;
    protected $fillable = ['clave_usuario','clave_cct'] ;
}
