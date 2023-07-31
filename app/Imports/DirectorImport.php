<?php

namespace App\Imports;

use App\Models\ModeloDirector;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class DirectorImport implements ToModel,WithHeadingRow
{
      
      /**


     @param array $row
    
    @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ModeloDirector([

            'clave_director'     => $row['clave_director'],
            'nombre_pila'    => $row['nombre_pila'], 
            'apellido_paterno'     => $row['apellido_paterno'],
            'apellido_materno'    => $row['apellido_materno'],
            'correo'    => $row['correo'], 


        ]);
    }
}
