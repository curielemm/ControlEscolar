<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloInstitucion;
use App\Models\ModeloInstituciones;

use App\Models\ModeloDirector;
use App\Models\ModeloTipoDirectivo;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Validator;

use DB;


class ControllerInstitucion extends Controller
{



  public function ver_InstitucionesDinamico()
  {
    return view('InstitucionesDinamico');
  }
  public function insert(Request $request)
  {
    /* if($request->ajax())
     {
      $rules = array(
            'nombre_institucion.*' => ['required','string', 'min:5','max:120'],
            'clave_cct.*' => ['required', 'string', 'min:3', 'max:12','unique:institucion'],
            'clave_dgpi.*' => ['required', 'string', 'min:3', 'max:10','unique:institucion'],
            'codigo_postal.*' => ['required', 'integer', 'min:5', 'max:5'],
            'calle.*' => ['required', 'string', 'max:120'],
            'numero_interior.*' => ['string', 'min:1','max:25'],
            'numero_exterior.*' => ['required', 'string', 'min:1', 'max:25'],
            'colonia.*' => ['required', 'string', 'min:1', 'max:120'],
            'municipio.*' => ['required', 'string', 'min:1', 'max:120'],
            'id_tipo_directivo.*' => ['required', 'integer', 'max:2'],
            'directivo_autorizado.*' => ['required', 'string', 'min:1', 'max:120'],
            'pagina_web.*' => ['required', 'string', 'min:1', 'max:120'],
            'reglamento_institucional.*' => ['required', 'string', 'max:120'],
            'manual_organizacion.*' => ['required', 'string', 'max:120'],
      );

      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
             return redirect()->to('InsertarInstitucion');

       
      }

      $clave_cct = $request->clave_cct;
      $clave_dgpi = $request->clave_dgpi;
      $nombre_institucion = $request->nombre_institucion;
      $municipio = $request->municipio;
      $codigo_postal = $request->codigo_postal;
      $colonia = $request->colonia;
      $calle = $request->calle;
      $numero_interior = $request->numero_interior;
      $numero_exterior = $request->numero_exterior;
      $id_tipo_directivo = $request->id_tipo_directivo;
      $directivo_autorizado = $request->directivo_autorizado;
      $reglamento_institucional = $request->reglamento_institucional;
      $manual_organizacion = $request->manual_organizacion;
      $pagina_web = $request->pagina_web;


      for($count = 1; $count < count($clave_cct); $count++)
      {
       $data = array(
        'clave_cct' => $clave_cct[$count],
        'clave_dgpi' => $clave_dgpi[$count],
        'nombre_institucion'  => $nombre_institucion[$count],
        'municipio'  => $municipio[$count],
        'codigo_postal' => $codigo_postal[$count],
        'colonia'  => $colonia[$count],
        'calle'  => $calle[$count],
        'numero_interior'  => $numero_interior[$count],
        'numero_exterior' => $numero_exterior[$count],
        'id_tipo_directivo'  => $id_tipo_directivo[$count],
        'directivo_autorizado'  => $directivo_autorizado[$count],
        'reglamento_institucional'  => $reglamento_institucional[$count],
        'manual_organizacion'  => $manual_organizacion[$count],
        'pagina_web'  => $pagina_web[$count]

       );
       $insert_data[] = $data;
      }

      //ModeloInstitucion::insert($insert_data);
      //return redirect()->to('confirmacion');
      return $data;

     }
     */
    return $request->all();
  }


  function ver_director(Request $var)
  {
    //$consulta =   ModeloCarrera::get(['nombre']);
    //return $consulta;
    $director = ModeloDirector::all();
    return view('InstitucionesDinamico', compact('director'));
  }

  function ver_director2()
  {
    $directores = ModeloDirector::select(DB::raw("CONCAT(director.nombre_pila,' ',director.apellido_paterno,' ',director.apellido_materno) as full_name"))->get();
    return view('InstitucionesDinamico', compact('directores'));
  }



  ///nuevas 
  public function ver_RegistroInst()
  {
    return view('InsertarInstitucion');
  }

  public function ver_RegistroInst2()
  {
    return view('validacionInstitucion');
  }

  public function insertEscuela(Request $var)
  {

    request()->validate([

      'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
      'clave_cct' => ['required', 'string', 'min:3', 'max:15', 'unique:institucion'],
      'clave_dgpi' => ['required', 'string', 'min:3', 'max:10', 'unique:institucion'],
      'codigo_postal' => ['required', 'integer'],
      'calle' => ['required', 'string', 'max:120'],
      'numero_exterior' => ['required', 'string'],
      'numero_interior' => ['nullable', 'string'],

      'colonia' => ['required', 'string', 'min:1', 'max:120'],
      'municipio' => ['required', 'string', 'min:1', 'max:120'],
      'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:5'],
      'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120','regex:/^.+[\pL\s\-]+$/i'],
      'pagina_web' => ['nullable'],
      'periodico_oficial' => ['nullable'],
      'id_tipo_institucion' => ['required']


    ]);



    $nombre_institucion = $var->input('nombre_institucion');
    $clave_cct = $var->input('clave_cct');
    $clave_dgpi = $var->input('clave_dgpi');
    $codigo_postal = $var->input('codigo_postal');

    $calle = $var->input('calle');
    $numero_interior = $var->input('numero_interior');
    $numero_exterior = $var->input('numero_exterior');
    $colonia = $var->input('colonia');

    $municipio = $var->input('municipio');
    $id_tipo_directivo = $var->input('id_tipo_directivo');
    $directivo_autorizado = $var->input('directivo_autorizado');
    $pagina_web = $var->input('pagina_web');

    $periodico_oficial = $var->input('periodico_oficial');
    $id_tipo_institucion = $var->input('id_tipo_institucion');

    $clave_usuario = auth()->user()->clave_usuario;
    $correo_usuario = auth()->user()->email;
    $statement = "SET @clave_usuario ="."'".$clave_usuario."'";
    $statement2 = "SET @correo_usuario ="."'".$correo_usuario."'";
     DB::statement($statement);
     DB::statement($statement2);
    // return $valor;
    ModeloInstitucion::create(['nombre_institucion' => $nombre_institucion, 'clave_cct' => $clave_cct, 'clave_dgpi' => $clave_dgpi, 'codigo_postal' => $codigo_postal, 'calle' => $calle, 'numero_interior' => $numero_interior, 'numero_exterior' => $numero_exterior, 'colonia' => $colonia, 'municipio' => $municipio, 'id_tipo_directivo' => $id_tipo_directivo, 'directivo_autorizado' => $directivo_autorizado, 'pagina_web' => $pagina_web, 'periodico_oficial' => $periodico_oficial, 'id_tipo_institucion' => $id_tipo_institucion]);

    return redirect()->to('confirmacion');
    //return redirect('/');
  }

  public function aviso()
  {
    return view('confirmacionInstitucion');
  }

  public function store()
  {

    request()->validate([

      'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
      'clave_cct' => ['required', 'string', 'min:3', 'max:15', 'unique:institucion'],
      'clave_dgpi' => ['required', 'string', 'min:3', 'max:10', 'unique:institucion'],
      'codigo_postal' => ['required', 'integer'],
      'calle' => ['required', 'string', 'max:120'],
      'numero_exterior' => ['required', 'integer'],
      'numero_interior' => ['integer'],
      'colonia' => ['required', 'string', 'max:120'],
      'municipio' => ['required', 'string', 'max:120'],
      'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:2'],
      'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],
      'pagina_web' => ['required', 'string', 'max:120'],
      'reglamento_institucional' => ['required', 'string', 'min:1',  'max:250'],
      'manual_organizacion' => ['required', 'string', 'min:1',  'max:250']

    ]);

    return 'datos validados';
  }


  public function ver_tipo_directivos(Request $var)
  {

    $tipos = ModeloTipoDirectivo::all();
    $tipoIns = DB::table('tipo_institucion')->where('id_tipo_institucion', '1')->get();

    return view('validacionInstitucion', compact('tipos', 'tipoIns'));
  }

  public function ver_tipo_directivos2(Request $var)
  {

    $tipos = ModeloTipoDirectivo::all();
    $tipoIns = DB::table('tipo_institucion')->where('id_tipo_institucion', '2')->get();
    return view('formMSU', compact('tipos', 'tipoIns'));
  }

  public function ver_formMSU()
  {
    return view('formMSU');
  }


  public function selectCPT(Request $var)
  {

    $tipos = ModeloTipoDirectivo::all();
    $tipoIns = DB::table('tipo_institucion')->where('id_tipo_institucion', '3')->get();
    return view('formCPT', compact('tipos', 'tipoIns'));
  }

  public function ver_formCPT()
  {
    return view('formCPT');
  }

  public function perfilInstitucion($clave_cct)
  {
    $uno['uno'] = ModeloInstitucion::select(
      'institucion.clave_cct',
      'institucion.clave_dgpi',
      'institucion.nombre_institucion',
      'institucion.municipio',
      'institucion.codigo_postal',
      'institucion.colonia',
      'institucion.calle',
      'institucion.numero_interior',
      'institucion.numero_exterior',
      'institucion.telefono',
      'institucion.correo',
      'institucion.pagina_web',
      'institucion.directivo_autorizado'
    )->where('clave_cct', '=', $clave_cct)->take(1)->first();
    return view('institucion', $uno);
  }


  public function insertEscuelaMSU(Request $var)
  {

    request()->validate([

      'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
      'clave_cct' => ['required', 'string', 'min:3', 'max:15', 'unique:institucion'],
      'id_tipo_institucion' => ['required'],
      'codigo_postal' => ['required', 'integer'],
      'calle' => ['required', 'string', 'max:120'],
      'numero_exterior' => ['required', 'string'],
      'numero_interior' => ['nullable'],

      'colonia' => ['required', 'string', 'min:1', 'max:120'],
      'municipio' => ['required', 'string', 'min:1', 'max:120'],
      'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:5'],
      'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],
      'pagina_web' => ['nullable'],
      'periodico_oficial' => ['nullable']


    ]);



    $nombre_institucion = $var->input('nombre_institucion');
    $clave_cct = $var->input('clave_cct');
    $id_tipo_institucion = $var->input('id_tipo_institucion');

    $codigo_postal = $var->input('codigo_postal');

    $calle = $var->input('calle');
    $numero_interior = $var->input('numero_interior');
    $numero_exterior = $var->input('numero_exterior');
    $colonia = $var->input('colonia');

    $municipio = $var->input('municipio');
    $id_tipo_directivo = $var->input('id_tipo_directivo');
    $directivo_autorizado = $var->input('directivo_autorizado');
    $pagina_web = $var->input('pagina_web');

    $periodico_oficial = $var->input('periodico_oficial');

    $clave_usuario = auth()->user()->clave_usuario;
    $correo_usuario = auth()->user()->email;
    $statement = "SET @clave_usuario ="."'".$clave_usuario."'";
    $statement2 = "SET @correo_usuario ="."'".$correo_usuario."'";
     DB::statement($statement);
     DB::statement($statement2);

    ModeloInstitucion::create(['nombre_institucion' => $nombre_institucion, 'clave_cct' => $clave_cct, 'id_tipo_institucion' => $id_tipo_institucion, 'codigo_postal' => $codigo_postal, 'calle' => $calle, 'numero_interior' => $numero_interior, 'numero_exterior' => $numero_exterior, 'colonia' => $colonia, 'municipio' => $municipio, 'id_tipo_directivo' => $id_tipo_directivo, 'directivo_autorizado' => $directivo_autorizado, 'pagina_web' => $pagina_web, 'periodico_oficial' => $periodico_oficial]);

    return redirect()->to('avisoMSU');
    //return redirect('/');
  }

  public function avisoMSU()
  {
    return view('avisoMSU');
  }


  public function insertEscuelaCPT(Request $var)
  {

    request()->validate([

      'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
      'clave_cct' => ['required', 'string', 'min:3', 'max:15', 'unique:institucion'],
      'id_tipo_institucion' => ['required'],
      'codigo_postal' => ['required', 'integer'],
      'calle' => ['required', 'string', 'max:120'],
      'numero_exterior' => ['required', 'string'],
      'numero_interior' => ['nullable'],

      'colonia' => ['required', 'string', 'min:1', 'max:120'],
      'municipio' => ['required', 'string', 'min:1', 'max:120'],
      'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:5'],
      'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],
      'pagina_web' => ['nullable'],
      'periodico_oficial' => ['nullable']


    ]);



    $nombre_institucion = $var->input('nombre_institucion');
    $clave_cct = $var->input('clave_cct');
    $id_tipo_institucion = $var->input('id_tipo_institucion');

    $codigo_postal = $var->input('codigo_postal');

    $calle = $var->input('calle');
    $numero_interior = $var->input('numero_interior');
    $numero_exterior = $var->input('numero_exterior');
    $colonia = $var->input('colonia');

    $municipio = $var->input('municipio');
    $id_tipo_directivo = $var->input('id_tipo_directivo');
    $directivo_autorizado = $var->input('directivo_autorizado');
    $pagina_web = $var->input('pagina_web');

    $periodico_oficial = $var->input('periodico_oficial');

    $clave_usuario = auth()->user()->clave_usuario;
    $correo_usuario = auth()->user()->email;
    $statement = "SET @clave_usuario ="."'".$clave_usuario."'";
    $statement2 = "SET @correo_usuario ="."'".$correo_usuario."'";
     DB::statement($statement);
     DB::statement($statement2);

    ModeloInstitucion::create(['nombre_institucion' => $nombre_institucion, 'clave_cct' => $clave_cct, 'id_tipo_institucion' => $id_tipo_institucion, 'codigo_postal' => $codigo_postal, 'calle' => $calle, 'numero_interior' => $numero_interior, 'numero_exterior' => $numero_exterior, 'colonia' => $colonia, 'municipio' => $municipio, 'id_tipo_directivo' => $id_tipo_directivo, 'directivo_autorizado' => $directivo_autorizado, 'pagina_web' => $pagina_web, 'periodico_oficial' => $periodico_oficial]);

    return redirect()->to('avisoCPT');
    //return redirect('/');
  }


  public function avisoCPT()
  {
    return view('avisoCPT');
  }
}
