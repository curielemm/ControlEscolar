<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloAlumnoPlan extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'alumno_plan';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'curp',
        'matricula',
        'rvoe',
        'vigencia',
        'status',
        'no_periodo'
    ];
}
