<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\Alumno;
use App\Models\ModeloGrupo;
use App\Models\ModeloAlumGpo;
use Maatwebsite\Excel\Facades\Excel;


// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Imports\AluInsImport;
use App\Imports\AlumnosImport;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAluGpoAsig;
use App\Models\ModeloAlumnoInscripcion;
use App\Models\ModeloAlumnoPlan;
use App\Models\ModeloAsignatura;
use App\Models\ModeloInsEquivalencia;
use App\Models\ModeloPlan;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;
use Psy\Util\Json as UtilJson;
use Validator;

class ControllerAlumnos extends Controller
{

  public function ver_formularioalumnos($rvoe, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupos = ModeloGrupo::select('grupo.clave_grupo', 'grupo.nombre_grupo', 'no_periodo', 'grupo.id_turno', 'fk_clave_ciclo_escolar')
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      //->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->where('plan_grupo.rvoe', '=', $rvoe)
      ->where('plan_grupo.vigencia', '=', $vigencia)->where('no_periodo', '=', 1)
      ->get();
    // return view('insertarAlumno', compact('datos', 'grupos'));
    //return $datos;
    $grupos2 = ModeloGrupo::select('grupo.clave_grupo', 'grupo.nombre_grupo', 'no_periodo', 'grupo.id_turno', 'fk_clave_ciclo_escolar')
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      //->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->where('plan_grupo.rvoe', '=', $rvoe)
      ->where('plan_grupo.vigencia', '=', $vigencia)->where('no_periodo', '>', 1)
      ->get();
    if (sizeof($grupos) == 0) {
      return redirect()->back()->with('message1', 'Agregue un grupo para inscribir alumnos');
    }
    return view('menuInscripcion', compact('datos', 'grupos', 'grupos2'));
  }

  public function ver_alumnosDinamico()
  {
    return view('AlumnosDinamico');
  }

  public function inserAlumnos($rvoe, $vigencia, Request $var)
  {
    request()->validate([

      'curp' => ['required', 'string', 'min:6', 'max:20',],
      'matricula' => ['required', 'string', 'min:5', 'max:20'],
      'nombre' => ['required'],
      'apellido_paterno' => ['required'],
      'apellido_materno' => ['required'],
      'sexo' => ['required'],
      'correo' => ['required'],
      'telefono' => ['required'],
    ]);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $curp = $var->input('curp');
    $matricula = $var->input('matricula');
    $nombre = $var->input('nombre');
    $apellido_paterno = $var->input('apellido_paterno');
    $apellido_materno = $var->input('apellido_materno');
    $sexo = $var->input('sexo');
    $correo = $var->input('correo');
    $telefono = $var->input('telefono');
    $clave_grupo = $var->input('clave_grupo');
    $acta_nacimiento = $var->input('acta_nacimiento');
    $curpt = $var->input('curpt');
    $certificado_secundaria = $var->input('certificado_secundaria');
    $certificado_bachillerato = $var->input('certificado_bachillerato');
    $certificado_lic = $var->input('certificado_lic');
    $titulo = $var->input('titulo');
    $cedula = $var->input('cedula');
    $certificado_ma = $var->input('certificado_ma');
    $titulo_ma = $var->input('titulo_ma');
    $cedula_ma = $var->input('cedula_ma');
    $no_periodo = $no_periodo = ModeloGrupo::select('no_periodo')->where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $no_periodo1 = $no_periodo['no_periodo'];

    if ($no_periodo1 == 1) {
      $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
        ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
      for ($j = 0; $j < sizeof($asignaturas); $j++) {
        $datas = [
          'curp' => $curp,
          'clave_grupo' => $clave_grupo,
          'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
          'rvoe' => $rvoe,
          'vigencia' => $vigencia,
          'status_aa' => 1,
        ];
        $insertAux[] = $datas;
      }
    }

    $alus = Alumno::select('curp')
      ->where('curp', '=', $curp)
      ->take(1)
      ->first();

    if ($alus == null) {
      Alumno::create([
        'curp' => $curp, 'nombre' => $nombre, 'apellido_paterno' => $apellido_paterno, 'apellido_materno' => $apellido_materno,
        'sexo' => $sexo, 'correo' => $correo, 'telefono' => $telefono, 'status_inscripcion' => 1
      ]);
    }

    $alusinscr_institucion = ModeloAlumnoInscripcion::select('fk_curp_alumno')
      ->join('alumno', 'alumno.curp', '=', 'alumno_inscripcion.fk_curp_alumno')
      ->where('fk_curp_alumno', '=', $curp)
      ->where('alumno.status_inscripcion', '=', 1)
      ->take(1)
      ->first();

    $alugpo = ModeloAlumGpo::select('curp')
      ->where('curp', '=', $curp)
      //->where('clave_grupo', '=', $clave_grupo)
      ->where('rvoe', '=', $rvoe)
      ->take(1)
      ->first();

    if ($alugpo != null) {
      return redirect()->back()->with('message1', 'El alumno ya se encuentra inscrito en un grupo');
    }

    if ($alusinscr_institucion == null) {
      ModeloAlumnoInscripcion::create([
        'fk_curp_alumno' => $curp,
        'fk_rvoe' => $rvoe,
        'matricula' => $matricula,
        'status_inscripcion' => 0,
        'acta_nacimiento' => $acta_nacimiento,
        'curp_doc' => $curpt,
        'certificado_secundaria' => $certificado_secundaria,
        'certificado_bachillerato' => $certificado_bachillerato,
        'certificado_lic' => $certificado_lic,
        'titulo' => $titulo, 'cedula' => $cedula,
        'certificado_ma' => $certificado_ma,
        'titulo_ma' => $titulo_ma,
        'cedula_ma' => $cedula_ma
      ]);
      ModeloAlumGpo::create(['clave_grupo' => $clave_grupo, 'curp' => $curp, 'rvoe' => $rvoe]);
      $clave_usuario = auth()->user()->clave_usuario;
      $correo_usuario = auth()->user()->email;
      $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
      $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
      DB::statement($statement);
      DB::statement($statement2);
      if ($no_periodo1 == 1) {
        ModeloAluGpoAsig::insert($insertAux);
      }

      ModeloAlumnoPlan::create([
        'curp' => $curp, 'matricula' => $matricula, 'rvoe' => $rvoe, 'vigencia' => $vigencia,
        'status' => 1, 'no_periodo' => $no_periodo1
      ]);

      return redirect()->back()->with('message', 'Datos agregados correctamente');
    } else {

      return redirect()->back()->with('message1', 'El alumno ya se encuentra inscrito en otra institucion');
    }
    /** 
     * verificiacion del usuario que esta haciendo la operacion.
     */
  }

  function insertarAlumnosEquivalencia($rvoe, $vigencia, Request $var)
  {
    request()->validate([

      'curp' => ['required', 'string', 'min:6', 'max:20',],
      'matricula' => ['required', 'string', 'min:5', 'max:20'],
      'nombre' => ['required'],
      'apellido_paterno' => ['required'],
      'apellido_materno' => ['string'],
      'sexo' => ['required'],
      'correo' => ['required'],
      'telefono' => ['required'],
    ]);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $curp = $var->input('curp');
    $matricula = $var->input('matricula');
    $nombre = $var->input('nombre');
    $apellido_paterno = $var->input('apellido_paterno');
    $apellido_materno = $var->input('apellido_materno');
    $sexo = $var->input('sexo');
    $correo = $var->input('correo');
    $telefono = $var->input('telefono');
    $clave_grupo = $var->input('clave_grupo');
    $acta_nacimiento = $var->input('acta_nacimiento');
    $curpt = $var->input('curpt');
    $certificado_secundaria = $var->input('certificado_secundaria');
    $certificado_bachillerato = $var->input('certificado_bachillerato');
    $certificado_lic = $var->input('certificado_lic');
    $titulo = $var->input('titulo');
    $cedula = $var->input('cedula');
    $certificado_ma = $var->input('certificado_ma');
    $titulo_ma = $var->input('titulo_ma');
    $cedula_ma = $var->input('cedula_ma');
    $no_periodo = $no_periodo = ModeloGrupo::select('no_periodo')->where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $no_periodo1 = $no_periodo['no_periodo'];
    $folio_equivalencia = $var->input('folio_equivalencia');
    $certificadoParcial = $var->input('certificado_parcial');
    $equivalencia = $var->input('equivalencia');

    /* if ($no_periodo1 == 1) {
      $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
        ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
      for ($j = 0; $j < sizeof($asignaturas); $j++) {
        $datas = [
          'curp' => $curp,
          'clave_grupo' => $clave_grupo,
          'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
          'rvoe' => $rvoe,
          'vigencia' => $vigencia,
          'status_aa' => 1,
        ];
        $insertAux[] = $datas;
      }
    }*/

    $alus = Alumno::select('curp')
      ->where('curp', '=', $curp)
      ->take(1)
      ->first();

    if ($alus == null) {
      Alumno::create([
        'curp' => $curp, 'nombre' => $nombre, 'apellido_paterno' => $apellido_paterno, 'apellido_materno' => $apellido_materno,
        'sexo' => $sexo, 'correo' => $correo, 'telefono' => $telefono, 'status_inscripcion' => 1
      ]);
    }

    $alusinscr_institucion = ModeloAlumnoInscripcion::select('fk_curp_alumno')
      ->join('alumno', 'alumno.curp', '=', 'alumno_inscripcion.fk_curp_alumno')
      ->where('fk_curp_alumno', '=', $curp)
      ->where('alumno.status_inscripcion', '=', 1)
      ->take(1)
      ->first();

    $alugpo = ModeloAlumGpo::select('curp')
      ->where('curp', '=', $curp)
      //->where('clave_grupo', '=', $clave_grupo)
      ->where('rvoe', '=', $rvoe)
      ->take(1)
      ->first();

    if ($alugpo != null) {
      return redirect()->back()->with('message1', 'El alumno ya se encuentra inscrito en un grupo');
    }

    if ($alusinscr_institucion == null) {
      ModeloAlumnoInscripcion::create([
        'fk_curp_alumno' => $curp,
        'fk_rvoe' => $rvoe,
        'matricula' => $matricula,
        'status_inscripcion' => 0,
        'acta_nacimiento' => $acta_nacimiento,
        'curp_doc' => $curpt,
        'certificado_secundaria' => $certificado_secundaria,
        'certificado_bachillerato' => $certificado_bachillerato,
        'certificado_lic' => $certificado_lic,
        'titulo' => $titulo, 'cedula' => $cedula,
        'certificado_ma' => $certificado_ma,
        'titulo_ma' => $titulo_ma,
        'cedula_ma' => $cedula_ma,
        'equivalencia/revalidacion' => 1
      ]);

      ModeloAlumGpo::create(['clave_grupo' => $clave_grupo, 'curp' => $curp, 'rvoe' => $rvoe]);
      $clave_usuario = auth()->user()->clave_usuario;
      $correo_usuario = auth()->user()->email;
      $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
      $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
      DB::statement($statement);
      DB::statement($statement2);
      ModeloAlumnoPlan::create([
        'curp' => $curp, 'matricula' => $matricula, 'rvoe' => $rvoe, 'vigencia' => $vigencia,
        'status' => 1, 'no_periodo' => $no_periodo1
      ]);

      ModeloInsEquivalencia::create([
        'fk_curp' => $curp,
        'clave_grupo' => $clave_grupo,
        'matricula' => $matricula,
        'status_inscripcion' => 0,
        'acta_nacimiento' => $acta_nacimiento,
        'curp_doc' => $curpt,
        'certificado_secundaria' => $certificado_secundaria,
        'certificado_bachillerato' => $certificado_bachillerato,
        'certificado_lic' => $certificado_lic,
        'titulo' => $titulo, 'cedula' => $cedula,
        'certificado_ma' => $certificado_ma,
        'certificado_parcial' => $certificadoParcial,
        'equivalencia' => $equivalencia,
        'folio_equivalencia' => $folio_equivalencia,
        'titulo_ma' => $titulo_ma,
        'cedula_ma' => $cedula_ma
      ]);

      return redirect()->route('califEquivalencias', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia), 'curp' => encrypt($curp), 'clave_grupo' => encrypt($clave_grupo)])->with('message2', 'Este grupo ya evaluó a sus alumnos ó no existen alumnos en este grupo');

      return redirect()->back()->with('message', 'Datos agregados correctamente');
    } else {

      return redirect()->back()->with('message1', 'El alumno ya se encuentra inscrito en otra institucion');
    }
    /** 
     * verificiacion del usuario que esta haciendo la operacion.
     */
  }

  public function avisoAlumnoAgregado()
  {
    return view('avisoAlumnoAgregado');
  }

  public function listarAlummnoss($rvoe)
  {
    $alumnos = Alumno::select('matricula', 'nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono')
      ->where('fk_rvoe', '=', $rvoe)
      ->paginate(5);
    return view('listarAlumnos', compact('alumnos'));
  }

  public function editar_datos($curp, $clave_grupo) //Jala los Datos del Alumno
  {

    // $uno['uno'] = Alumno::find($matricula);
    $uno['uno'] = Alumno::where('curp', $curp)->take(1)->first();

    return view('editarAlumno', $uno, compact('clave_grupo'));
  }



  public function actualizar_datos(Request $data, $curp)
  {
    $clave_grupo = $data->input('clave_grupo');
    $editar = Alumno::whereRaw('curp = ?', [$curp])->first();

    Alumno::where('curp', $curp)
      ->update([
        'matricula' => $data->matricula,
        'nombre' => $data->nombre,
        'apellido_paterno' => $data->apellido_paterno,
        'apellido_materno' => $data->apellido_materno,
        'sexo' => $data->genero,
        'correo' => $data->correo,
        'telefono' => $data->telefono
      ]);

    return redirect()->route('listarAlumnos', $clave_grupo)->with('message', 'Registro actualizado correctamente');
  }



  public function editar_datos_eliminar($curp)
  {
    $uno = Alumno::where('curp', $curp)->take(1)->first();
    return view('eliminarAlumno')
      ->with('uno', $uno);
  }



  public function eliminar_alumno($curp)
  {
    $editar = Alumno::where("curp", "=", "$curp");

    $editar->delete();

    return redirect()->to('listarAlumnos');
  }

  public function validarAlu($curp, $rvoe, $vigencia, $clave_cct, Request $request)
  {
    // $curp = $request->input('curp');
    $nivel = $request->input('nivel');
    $rvoe = $request->input('rvoe');
    $clave_grupo = $request->input('clave_grupo');
    $alumno = Alumno::select(
      'curp',
      'matricula',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'acta_nacimiento',
      'sexo',
      'correo',
      'telefono',
      'curp_doc',
      'acta_nacimiento',
      'certificado_secundaria',
      'certificado_bachillerato',
      'certificado_lic',
      'titulo',
      'cedula',
      'certificado_ma',
      'titulo_ma'
    )
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('alumno.curp', '=', $curp)->take(1)->first();
    return view('alumnoValidar', compact('alumno', 'nivel', 'clave_grupo', 'rvoe', 'vigencia', 'clave_cct'));
  }


  function insert(Request $request)
  {
    /*$grupo = $request->input('clave_grupo');


    if ($request->ajax()) {
      $rules = array(
        'matricula.*'  => 'required',
        'nombre.*'  => 'required',
        'apellido_paterno.*'  => 'required',
        'apellido_materno.*'  => 'required',
        'fecha_nacimiento.*'  => 'required',
        'curp.*'  => 'required',
        'correo.*'  => 'required',
        'telefono.*'  => 'required'

      );
      $error = Validator::make($request->all(), $rules);
      if ($error->fails()) {
        return response()->json([
          'error'  => $error->errors()->all()
        ]);
      }
/*
      $matricula = $request->matricula;
      $nombre = $request->nombre;
      $apellido_paterno = $request->apellido_paterno;
      $apellido_materno = $request->apellido_materno;
      $fecha_nacimiento = $request->fecha_nacimiento;
      $curp = $request->curp;
      $correo = $request->correo;
      $telefono = $request->telefono;


      for ($count = 0; $count < count($matricula); $count++) {
        $data = array(
          'matricula' => $matricula[$count],
          'nombre'  => $nombre[$count],
          'apellido_paterno'  => $apellido_paterno[$count],
          'apellido_materno'  => $apellido_materno[$count],
          'fecha_nacimiento'  => $fecha_nacimiento[$count],
          'curp'  => $curp[$count],
          'correo' => $correo[$count],
          'telefono'  => $telefono[$count]

        );
        $insert_data[] = $data;
      }


      for ($count2 = 0; $count2 < count($matricula); $count2++) {
        $data2 = array(
          'matricula_alumno' => $matricula[$count2],
          'clave_grupo' =>  $grupo[0]
        );
        $insert_data2[] = $data2;
      }


      Alumno::insert($insert_data);

      ModeloAlumGpo::insert($insert_data2);

      return response()->json([
        'success'  => 'Datos añadidos correctamente'
      ]);*/
    //}
    return $request->all();
  }


  function ver_grupo(Request $var)
  {
    $grupo = ModeloGrupo::all();
    return view('AlumnosDinamico', compact('grupo'));
  }

  function vistaImportExcel($rvoe, $vigencia)
  {
    /*$datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia','=',$vigencia)->take(1)->first();
    $grupos = ModeloGrupo::select('grupo.clave_grupo', 'grupo.nombre_grupo', 'no_periodo', 'grupo.id_turno', 'fk_clave_ciclo_escolar')
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->where('plan_estudio.rvoe', '=', $rvoe)
      ->get();*/
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $url = '';
    $nivel = $datos->id_nivel_educativo;
    if ($nivel == 3) {
      $url = 'Formato_Carga_Alumnos_L.csv';
    } else if ($nivel == 4 or $nivel == 5) {
      $url = 'Formato_Carga_Alumnos_EM.csv';
    } else if ($nivel == 6) {
      $url = 'Formato_Carga_Alumnos_D.csv';
    } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {
      $url = 'Formato_Carga_Alumnos_B.csv';
    }
    //return $datos;
    $grupos = ModeloGrupo::select('grupo.clave_grupo', 'grupo.nombre_grupo', 'no_periodo', 'grupo.id_turno', 'fk_clave_ciclo_escolar')
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      //->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->where('plan_grupo.rvoe', '=', $rvoe)
      ->where('plan_grupo.vigencia', '=', $vigencia)->where('no_periodo', '=', 1)
      ->get();
    return view('excel', compact('datos', 'grupos', 'rvoe', 'url'));
  }

  function importExcel(Request $request)
  {
    $rvoe = 'RVOEHOLA';
    $file = $request->file('file');
    Excel::import(new AlumnosImport, $file, $rvoe);
    Excel::import(new AluInsImport, $file);


    return redirect()->back()->with('message', 'Datos agregados correctamente');
  }

  function validarCabeceras($array, $nivel, $numCol)
  {

    if ($nivel == 3 && $numCol == 12) {
      if (
        $array[0] == 'CURP' && $array[1] == 'Matricula' && $array[2] == 'Nombre' && $array[3] == 'Apellido_Paterno' && $array[4] == 'Apellido_Materno' && $array[5] == 'Sexo'
        && $array[6] == 'Correo' && $array[7] == 'Telefono' && $array[8] == 'Acta_Nacimiento'  && $array[9] == 'CURP'  && $array[10] == 'Certificado_Secundaria'
        && $array[11] == 'Certificado_Bachillerato'
      ) {
        return true;
      }
      return false;
    } else if (($nivel == 4 or $nivel == 5) && $numCol == 13) {
      if (
        $array[0] == 'CURP' && $array[1] == 'Matricula' && $array[2] == 'Nombre' && $array[3] == 'Apellido_Paterno' && $array[4] == 'Apellido_Materno' && $array[5] == 'Sexo'
        && $array[6] == 'Correo' && $array[7] == 'Telefono' && $array[8] == 'Acta_Nacimiento'  && $array[9] == 'CURP'  && $array[10] == 'Certificado_Licenciatura'
        && $array[11] == 'Titulo' && $array[12] == 'Cedula'
      ) {
        return true;
      }
      return false;
    } else if ($nivel == 6 && $numCol == 13) {
      if (
        $array[0] == 'CURP' && $array[1] == 'Matricula' && $array[2] == 'Nombre' && $array[3] == 'Apellido_Paterno' && $array[4] == 'Apellido_Materno' && $array[5] == 'Sexo'
        && $array[6] == 'Correo' && $array[7] == 'Telefono' && $array[8] == 'Acta_Nacimiento'  && $array[9] == 'CURP'  && $array[10] == 'Certificado_Maestria'
        && $array[11] == 'Titulo_Maestria' && $array[12] == 'Cedula_Maestria'
      ) {
        return true;
      }
      return false;
    } else if (($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) && $numCol == 13) {
      if (
        $array[0] == 'CURP' && $array[1] == 'Matricula' && $array[2] == 'Nombre' && $array[3] == 'Apellido_Paterno' && $array[4] == 'Apellido_Materno' && $array[5] == 'Sexo'
        && $array[6] == 'Correo' && $array[7] == 'Telefono' && $array[8] == 'Acta_Nacimiento'  && $array[9] == 'CURP'  && $array[10] == 'Certificado_Secundaria'
      ) {
        return true;
      }
      return false;
    }

    return false;
  }

  function import2(Request $request)
  {
    $file = $request->file('file');
    $clave_grupo = $request->input('clave_grupo');
    $lines = file($file);
    $rvoe = $request->input('rvoe');
    $utf8_lines = array_map('utf8_encode', $lines);
    $array = array_map('str_getcsv', $utf8_lines);
    $numCol = sizeof($array[0]);
    $vigencia = $request->input('vigencia');
    $no_periodo = $no_periodo = ModeloGrupo::select('no_periodo')->where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $no_periodo1 = $no_periodo['no_periodo'];
    //for para agregar a la tabla alumno
    $nivel1 = ModeloPlan::select('id_nivel_educativo')->where('rvoe', '=', $rvoe)->take(1)->first();
    $nivel = $nivel1['id_nivel_educativo'];
    if ($this->validarCabeceras($array[0], $nivel, $numCol) == false) {
      return redirect()->back()->with('message2', 'Los nombres de las columnas no corresponden a las indicadas');
    }

    for ($i = 1; $i < sizeof($array); ++$i) {
      $data = [
        'curp' => $array[$i][0],
        'nombre'  =>  $array[$i][2],
        'apellido_paterno'  =>  $array[$i][3],
        'apellido_materno'  =>  $array[$i][4],
        'sexo'  =>   $array[$i][5],
        'correo'  =>   $array[$i][6],
        'telefono'  =>   $array[$i][7],
        'status_inscripcion' => 0,
      ];
      $alus = Alumno::select('curp')
        ->where('curp', '=', $array[$i][0])
        ->take(1)
        ->first();
      if ($alus != null) {
        //return back()->withInput()->withErrors($validator->errors());
        return redirect()->back()->with('message2', 'CURP: ' . $array[$i][0]. ' ya se ecuentra registrada');
      }
      $insert_data[] = $data;
    }
    //For para agregar a la tabla de alumno_inscripcion
    //condicionales
    if ($nivel == 3) {
      for ($i = 1; $i < sizeof($array); ++$i) {
        $data = [
          'fk_curp_alumno' => $array[$i][0],
          'matricula' => $array[$i][1],
          'acta_nacimiento'  =>   $array[$i][8],
          'curp_doc'  =>   $array[$i][9],
          'certificado_secundaria'  =>   $array[$i][10],
          'certificado_bachillerato'  =>   $array[$i][11],
          'status_inscripcion' => 0,
        ];
        $insert_data2[] = $data;
      }

      if ($no_periodo1 == 1) {
        $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
          ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
        for ($i = 1; $i < sizeof($array); ++$i) {
          for ($j = 0; $j < sizeof($asignaturas); $j++) {
            $datas = [
              'curp' => $array[$i][0],
              'clave_grupo' => $clave_grupo,
              'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
              'rvoe' => $rvoe,
              'vigencia' => $vigencia,
              'status_aa' => 1,
            ];
            $insertAux[] = $datas;
          }
        }
      }
    } else if ($nivel == 4 or $nivel == 5) {
      for ($i = 1; $i < sizeof($array); ++$i) {
        $data = [
          'fk_curp_alumno' => $array[$i][0],
          'matricula' => $array[$i][1],
          'acta_nacimiento'  =>   $array[$i][8],
          'curp_doc'  =>   $array[$i][9],
          'certificado_lic'  =>   $array[$i][10],
          'titulo'  =>   $array[$i][11],
          'cedula'  =>   $array[$i][12],
          'status_inscripcion' => 0,
        ];
        $insert_data2[] = $data;
      }
      if ($no_periodo1 == 1) {
        $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
          ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
        for ($i = 1; $i < sizeof($array); ++$i) {
          for ($j = 0; $j < sizeof($asignaturas); $j++) {
            $datas = [
              'curp' => $array[$i][0],
              'clave_grupo' => $clave_grupo,
              'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
              'rvoe' => $rvoe,
              'vigencia' => $vigencia,
              'status_aa' => 1,
            ];
            $insertAux[] = $datas;
          }
        }
      }
    } else if ($nivel == 6) {
      for ($i = 1; $i < sizeof($array); ++$i) {
        $data = [
          'fk_curp_alumno' => $array[$i][0],
          'matricula' => $array[$i][1],
          'acta_nacimiento'  =>   $array[$i][8],
          'curp_doc'  =>   $array[$i][9],
          'certificado_ma'  =>   $array[$i][10],
          'titulo_ma'  =>   $array[$i][11],
          'cedula_ma'  =>   $array[$i][12],
          'status_inscripcion' => 0,
        ];
        $insert_data2[] = $data;
      }
      if ($no_periodo1 == 1) {
        $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
          ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
        for ($i = 1; $i < sizeof($array); ++$i) {
          for ($j = 0; $j < sizeof($asignaturas); $j++) {
            $datas = [
              'curp' => $array[$i][0],
              'clave_grupo' => $clave_grupo,
              'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
              'rvoe' => $rvoe,
              'vigencia' => $vigencia,
              'status_aa' => 1,
            ];
            $insertAux[] = $datas;
          }
        }
      }
    } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {
      for ($i = 1; $i < sizeof($array); ++$i) {
        $data = [
          'fk_curp_alumno' => $array[$i][0],
          'matricula' => $array[$i][1],
          'acta_nacimiento'  =>   $array[$i][8],
          'curp_doc'  =>   $array[$i][9],
          'certificado_secundaria'  =>   $array[$i][10],
          'status_inscripcion' => 0,
        ];
        $insert_data2[] = $data;
      }
      if ($no_periodo1 == 1) {
        $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)
          ->where('vigencia', '=', $vigencia)->where('no_periodo', '=', $no_periodo1)->get();
        for ($i = 1; $i < sizeof($array); ++$i) {
          for ($j = 0; $j < sizeof($asignaturas); $j++) {
            $datas = [
              'curp' => $array[$i][0],
              'clave_grupo' => $clave_grupo,
              'clave_asignatura' => $asignaturas[$j]['clave_asignatura'],
              'rvoe' => $rvoe,
              'vigencia' => $vigencia,
              'status_aa' => 1,
            ];
            $insertAux[] = $datas;
          }
        }
      }
    }
    //alumnoGrupo
    for ($i = 1; $i < sizeof($array); ++$i) {
      $data = [
        'clave_grupo' => $clave_grupo,
        'curp' => $array[$i][0],
      ];
      $insert_data3[] = $data;
    }
    //alumnoPlan
    for ($i = 1; $i < sizeof($array); ++$i) {
      $data = [
        'curp' => $array[$i][0],
        'matricula' => $array[$i][1],
        'rvoe' => $rvoe,
        'vigencia' => $vigencia,
        'status' => 1,
        'no_periodo' => $no_periodo1
      ];
      $insert_data4[] = $data;
    }
    // var_dump($insert_data);+
    Alumno::insert($insert_data);
    ModeloAlumnoInscripcion::insert($insert_data2);
    ModeloAlumGpo::insert($insert_data3);
    ModeloAlumnoPlan::insert($insert_data4);
    if ($no_periodo1 == 1) {
      ModeloAluGpoAsig::insert($insertAux);
    }
    return redirect()->back()->with('message', 'Datos agregados correctamente');
  }
}
