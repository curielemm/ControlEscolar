<?php

namespace App\Imports;

use App\Models\Alumno;
use App\Models\ModeloAlumnoInscripcion;
use Maatwebsite\Excel\Concerns\ToModel;

class AlumnosImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return  new Alumno([
            'matricula' => $row[0],
            'nombre' => $row[1],
            'apellido_paterno' => $row[2],
            'apellido_materno' => $row[3],
            'curp' => $row[4],
            'fk_rvoe' => $row[5],
        ]);
    }
}
