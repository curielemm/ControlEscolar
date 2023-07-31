<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloInsEquivalencia extends Model
{
     //aqui se declara el nombre de la tabla que esta en mysql
  protected  $table = 'inscripcion_equivalencia';
  // aqui la llave primaria de la tabla
  public $timestamps = false;
  // aqui los elementos a mostrarse de la tabla en cuestion
  protected $fillable = [
    'fk_curp',
    'clave_grupo',
    'acta_nacimiento',
    'curp_doc',
    'certificado_secundaria',
    'certificado_bachillerato',
    'certificado_lic',
    'titulo',
    'cedula',
    'titulo_ma',
    'certificado_parcial',
    'folio_equivalencia',
    'equivalencia',
  ];
}
