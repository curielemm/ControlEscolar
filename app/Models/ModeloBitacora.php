<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloBitacora extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'bitacora';
    // aqui la llave primaria de la tabla
    protected $primarykey = 'id_bitacora';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'clave_usuario', 'correo_usuario'
    ];
}
