<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ModeloInsPlanCPT extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'institucion-plan_cpt';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'clave_cct','rvoe_cpt'];
}