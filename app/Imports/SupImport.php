<?php

namespace App\Imports;

use App\Models\ModeloInstitucion;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class SupImport implements ToModel,WithHeadingRow
{
      
      /**


     @param array $row
    
    @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ModeloInstitucion([

            'clave_cct'     => $row['clave_cct'],
            'clave_dgpi'    => $row['clave_dgpi'], 
            'nombre_institucion'     => $row['nombre_institucion'],
            'codigo_postal'    => $row['codigo_postal'],
            'calle'    => $row['calle'], 
            'colonia'     => $row['colonia'],
            'municipio'    => $row['municipio'], 
            'numero_interior'     => $row['numero_interior'],
            'numero_exterior'    => $row['numero_exterior'],
            'directivo_autorizado'    => $row['directivo_autorizado'], 
            'id_tipo_directivo'    => $row['id_tipo_directivo'], 
            'id_tipo_institucion'     => $row['id_tipo_institucion']

        ]);
    }
}
