<?php

namespace App\Exports;

use App\Models\ModeloDirector;
use Maatwebsite\Excel\Concerns\FromCollection;

class DirectorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModeloDirector::all();
    }
}
