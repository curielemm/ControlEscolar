<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloCicloEscolar extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'ciclo_escolar';
    // aqui la llave primaria de la tabla
    protected $primarykey = 'id_ciclo_escolar';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'id_ciclo_escolar', 'fecha_inicio', 'fecha_fin'
    ];
}
