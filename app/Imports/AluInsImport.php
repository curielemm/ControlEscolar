<?php

namespace App\Imports;

use App\Models\ModeloAlumnoInscripcion;
use Maatwebsite\Excel\Concerns\ToModel;

class AluInsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ModeloAlumnoInscripcion([
            'fk_curp_alumno' => $row[4],

        ]);
    }
}
