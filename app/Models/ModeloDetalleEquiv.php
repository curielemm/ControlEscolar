<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloDetalleEquiv extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'detalle_equivalencia';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'folio_equivalencia',
        'curp',
        'fk_clave_asignatura',
        'calificacion',
        'fk_id_status',
        'rvoe',
        'vigencia',
    ];
}
