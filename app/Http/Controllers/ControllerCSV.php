<?php

namespace App\Http\Controllers; //se declara el controlador

  
use Illuminate\Http\Request;
use App\Exports\DirectorExport;
use App\Imports\DirectorImport;
use App\Exports\SupExport;
use App\Imports\SupImport;
use App\Exports\MSUExport;
use App\Imports\MSUImport;
use App\Exports\CPTExport;
use App\Imports\CPTImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ModeloDirector;
use App\Models\ModeloInstitucion;


class ControllerCSV extends Controller
{
    /**

    * @return \Illuminate\Support\Collection
    */

    public function vistaImportar()
    {
       return view('import');
    }

    public function vistaImportarSup()
    {
       return view('importInstSup');
    }

      public function vistaImportarMSU()
    {
       return view('importInstMSU');
    }

     public function vistaImportarCPT()
    {
       return view('importInstCPT');
    }




    function index(){
        $data = ModeloDirector::select('clave_director','nombre_pila','apellido_paterno','apellido_materno','correo')->paginate(10);
        return view('csv_file_pagination',compact('data'))->with('i', (request()->input('page',1)-1)*10);
    }

    function indexSup(){
        $data = ModeloInstitucion::select('clave_cct','nombre_institucion','codigo_postal','colonia','municipio','id_tipo_directivo','directivo_autorizado')->paginate(10);
        return view('csv_file_pagination_sup',compact('data'))->with('i', (request()->input('page',1)-1)*10);
    }

    function indexMSU(){
        $data = ModeloInstitucion::select('clave_cct','nombre_institucion','codigo_postal','colonia','municipio','id_tipo_directivo','directivo_autorizado')->paginate(10);
        return view('csv_file_pagination_msu',compact('data'))->with('i', (request()->input('page',1)-1)*10);
    }

    function indexCPT(){
        $data = ModeloInstitucion::select('clave_cct','nombre_institucion','codigo_postal','colonia','municipio','id_tipo_directivo','directivo_autorizado')->paginate(10);
        return view('csv_file_pagination_cpt',compact('data'))->with('i', (request()->input('page',1)-1)*10);
    }
    /**
    /**
    /**

    * @return \Illuminate\Support\Collection

    */

    public function export() 

    {
        return Excel::download(new DirectorExport, 'directores.xlsx');

    }

    public function exportSup() 

    {
        return Excel::download(new SupExport, 'nivelsuperior.xlsx');

    }

    public function exportMSU() 

    {
        return Excel::download(new MSUExport, 'nivelmediosuperior.xlsx');

    }

    public function exportCPT() 

    {
        return Excel::download(new CPTExport, 'nivelcapacitaciontrabajo.xlsx');

    }



   
    /**

    * @return \Illuminate\Support\Collection

    */

    public function import() 

    {
        Excel::import(new DirectorImport,request()->file('file'));
        return back();

    }

    public function importSup() 

    {
        Excel::import(new SupImport,request()->file('file'));
        return back();

    }

     public function importMSU() 

    {
        Excel::import(new MSUImport,request()->file('file'));
        return back();

    }

     public function importCPT() 

    {
        Excel::import(new CPTImport,request()->file('file'));
        return back();

    }

  
}
