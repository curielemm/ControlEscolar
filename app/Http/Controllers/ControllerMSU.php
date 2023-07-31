<?php

namespace App\Http\Controllers; //se declara el controlador


use App\Models\ModeloTipoDirectivo;
use App\Models\ModeloMSU;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Validator;

use DB;

class ControllerMSU extends Controller
{

     public function ver_formMSU()
  {
     return view('formMSU');

  }


  public function insertMSU(Request $var)
        {

          request()->validate([

            'nombre_institucion_msu' => ['required','string', 'min:5','max:150'],
            'clave_cct_msu' => ['required', 'string', 'min:3', 'max:15','unique:media_superior'],
  
            'codigo_postal' => ['required', 'integer'],
            'calle' => ['required', 'string', 'max:120'],
            'numero_exterior' => ['required', 'integer'],
            'numero_interior' => ['nullable','integer'],
            
            'colonia' => ['required', 'string', 'min:1', 'max:120'],
            'municipio' => ['required', 'string', 'min:1', 'max:120'],
            'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:2'],
            'nombre_directivo' => ['required', 'string', 'min:1', 'max:200'],
            'pagina_web' => ['required', 'string', 'min:1', 'max:120'],
            'reglamento_institucional' => ['required', 'string', 'max:250'],
            'manual_organizacion' => ['required']


        ]);



          $nombre_institucion_msu = $var -> input('nombre_institucion_msu');
          $clave_cct_msu = $var -> input('clave_cct_msu');
  
          $codigo_postal = $var -> input('codigo_postal');

          $calle = $var -> input('calle');
          $numero_interior = $var -> input('numero_interior');
          $numero_exterior = $var -> input('numero_exterior');
          $colonia = $var -> input('colonia');

          $municipio = $var -> input('municipio');
          $id_tipo_directivo = $var -> input('id_tipo_directivo');
          $nombre_directivo = $var -> input('nombre_directivo');
          $pagina_web = $var -> input('pagina_web');

          $reglamento_institucional = $var -> input('reglamento_institucional');
          $manual_organizacion = $var -> input('manual_organizacion');


        ModeloMSU:: create(['nombre_institucion_msu' => $nombre_institucion_msu,'clave_cct_msu' => $clave_cct_msu, 'codigo_postal' => $codigo_postal,'calle' => $calle,'numero_interior' => $numero_interior, 'numero_exterior' => $numero_exterior,'colonia' => $colonia,'municipio' => $municipio, 'id_tipo_directivo' => $id_tipo_directivo,'nombre_directivo' => $nombre_directivo,'pagina_web' => $pagina_web,'reglamento_institucional' => $reglamento_institucional,'manual_organizacion' => $manual_organizacion]);

        return redirect()->to('avisoMSU');
        //return redirect('/');
        }

    public function aviso(){
        return view('avisoMSU'); 
    }

   public function store()
    {
         
        request()->validate([

            'nombre_institucion' => ['required','string', 'min:5','max:150'],
            'clave_cct' => ['required', 'string', 'min:3', 'max:15','unique:institucion'],
            'clave_dgpi' => ['required', 'string', 'min:3', 'max:10','unique:institucion'],
            'codigo_postal' => ['required', 'integer'],
            'calle' => ['required', 'string', 'max:120'],
             'numero_exterior' => ['required', 'integer'],
            'numero_interior' => ['integer'],
            'colonia' => ['required', 'string', 'max:120'],
            'municipio' => ['required', 'string', 'max:120'],
            'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:2'],
            'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],
            'pagina_web' => ['required', 'string', 'max:120'],
            'reglamento_institucional' => ['required', 'string','min:1',  'max:250'],
            'manual_organizacion' => ['required', 'string','min:1',  'max:250']

        ]);

         return 'datos validados';
    }


   public function ver_tipo_directivos(Request $var){
        
         $tipos = ModeloTipoDirectivo::all();
      return view('formMSU', compact('tipos'));

      }
    



}