<?php

namespace App\Exports;

use App\Models\ModeloInstitucion;
use Maatwebsite\Excel\Concerns\FromCollection;

class CPTExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModeloInstitucion::all()->where('id_tipo_institucion','3');
    }
}