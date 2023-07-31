<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'director';
    // aqui la llave primaria de la tabla

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primarykey = 'clave_director';
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
      'clave_director','nombre_pila','apellido_paterno','apellido_materno','correo'];
}
