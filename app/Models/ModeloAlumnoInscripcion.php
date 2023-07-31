<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloAlumnoInscripcion extends Model
{
    //aqui se declara el nombre de la tabla que esta en mysql
    protected  $table = 'alumno_inscripcion';
    // aqui la llave primaria de la tabla
    public $timestamps = false;
    // aqui los elementos a mostrarse de la tabla en cuestion
    protected $fillable = [
        'fk_curp_alumno', 'matricula', 'fk_rvoe', 'fk_clave_grupo', 'acta_nacimiento',
        'fk_id_certificado',
        'status_inscripcion', 'curp_doc', 'observaciones',
        'fecha_aclaracion', 'semestre_a_inscribir', 'certificado_secundaria', 'certificado_bachillerato', 'certificado_lic', 'titulo', 'cedula',
        'certificado_ma', 'titulo_ma', 'cedula_ma', 'equivalencia/revalidacion'
    ];
}
