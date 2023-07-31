<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloGrupo;
use App\Models\ModeloAsignatura;
use App\Models\ModeloDocente;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAluGpoAsig;
use App\Models\ModeloAlumGpo;
use App\Models\ModeloAlumnoInscripcion;
use App\Models\ModeloAlumnoPlan;
use App\Models\ModeloAsignaturaSeriacion;
use App\Models\ModeloCalificacionesExtra;
use App\Models\ModeloCicloEscolar;
use App\Models\ModeloInsEquivalencia;
use App\Models\ModeloInstitucion;
use App\Models\ModeloPlan;
use App\Models\ModeloPlanGrupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use stdClass;
use Validator;

class ControllerGrupo extends Controller
{

  public function ver_formularioGrupo($rvoe, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $clave_institucion = auth()->user()->institucion;
    $ciclo = ModeloCicloEscolar::select('id_ciclo_escolar')->where('actual', '=', 1)->get();
    $turno = DB::table('turno')->get();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'actualizacion_plan.vigencia'
    )
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    //return $turno;
    return view('insertarGrupo', compact('datos', 'ciclo', 'turno'));
  }

  public function insertarGrupo(Request $var, $rvoe, $vigencia)
  {
    request()->validate([
      'nombre_grupo' => ['required', 'string', 'min:1', 'max:15','alpha_num'],
      'no_periodo' => ['required', 'integer'],
      'fecha_iniP' => ['required', 'date'],
      'fecha_finP' => ['required', 'date'],
      'id_turno' => ['required', 'integer'],
      'id_ciclo_escolar' => ['required', 'string'],
    ]);
    $clave_grupo = $var->input('clave_grupo');
    $nombre_grupo = $var->input('nombre_grupo');
    $no_periodo = $var->input('no_periodo');
    $fecha_ini = $var->input('fecha_iniP');
    $fecha_fin = $var->input('fecha_finP');
    $turno = $var->input('id_turno');
    $ciclo = $var->input('id_ciclo_escolar');
    $vigencia = $var->input('vigencia');
    $subVige = substr($vigencia, 0, 4);
    $subNom = substr($nombre_grupo, 0, 5);
    $subRv = substr($rvoe, 0, 5);
    $clave_grupo = $no_periodo . $subNom . $subRv . $ciclo . $subVige;
    $data = [
      'clave_grupo' => $clave_grupo,
    ];
    $validator = Validator::make($data, [
      'clave_grupo' => 'unique:grupo',
      //'nombre' => 'required',

    ]);
    if ($validator->fails()) {
      //return back()->withInput()->withErrors($validator->errors());
      return redirect()->back()->with('message2', 'Nombre de Grupo ya esta con ese periodo y ciclo escolar');
    }

    $clave_usuario = auth()->user()->clave_usuario;
    $correo_usuario = auth()->user()->email;
    $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
    $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
    DB::statement($statement);
    DB::statement($statement2);

    ModeloGrupo::create([
      'clave_grupo' => $clave_grupo, 'nombre_grupo' => $nombre_grupo, 'no_periodo' => $no_periodo, 'fecha_ini' => $fecha_ini, 'fecha_fin' => $fecha_fin,
      'id_turno' => $turno, 'fk_rvoe' => $rvoe, 'fk_clave_ciclo_escolar' => $ciclo
    ]);

    ModeloPlanGrupo::create(['rvoe' => $rvoe, 'vigencia' => $vigencia, 'clave_grupo' => $clave_grupo, 'id_ciclo_escolar' => $ciclo]);

    return redirect()->route('avisoGrupoAgregado', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)]);
  }

  public function formEditarGrupo($rvoe, $clave_grupo, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $clave_grupo = decrypt($clave_grupo);
    $vigencia = decrypt($vigencia);
    $clave_institucion = auth()->user()->institucion;
    $grupo =  ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'fk_clave_ciclo_escolar',
      'turno.nombre_turno',
      'grupo.id_turno'
    )
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $ciclo = ModeloCicloEscolar::select('id_ciclo_escolar')->get();
    $turno = DB::table('turno')->get();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'vigencia'
    )
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    //return $turno;
    return view('editarGrupo', compact('datos', 'ciclo', 'turno', 'grupo'));
  }

  public function editarGrupo(Request $var, $rvoe, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    request()->validate([
      //'nombre_grupo' => ['required', 'string', 'min:1', 'max:15'],
      // 'no_periodo' => ['required', 'integer'],
      'fecha_iniP' => ['required', 'date'],
      'fecha_finP' => ['required', 'date'],
      'id_turno' => ['required', 'integer'],
      //'id_ciclo_escolar' => ['required', 'string'],
    ]);
    $clave_grupo = $var->input('clave_grupo');
    $fecha_ini = $var->input('fecha_iniP');
    $fecha_fin = $var->input('fecha_finP');
    $nombre_grupo = $var->input('nombre_grupo');
    $no_periodo = $var->input('no_periodo');
    $periodo_escolar = $var->input('periodo_escolar');
    $turno = $var->input('id_turno');
    $ciclo = $var->input('id_ciclo_escolar');

    ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->update([
      'fecha_ini' => $fecha_ini,
      'fecha_fin' => $fecha_fin,
      'id_turno' => $turno, 'fk_rvoe' => $rvoe,
    ]);

    return redirect()->route('verGrupos', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)])->with('message', 'Registro editado correctamente');
  }

  public function eliminarGrupo($clave_grupo, $rvoe, $vigencia)
  {
    $alumnos = Alumno::selectRaw(
      'alumno.curp,count(alumno.curp)'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo) // ->where('alumno.status_inscripcion', '=', '0')
      ->groupBy('alumno.curp')->get()
      ->count();
    if ($alumnos > 0) {
      return redirect()->route('verGrupos', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)])->with('message2', 'No se puede eliminar el Grupo porque contiene alumnos.');
    }

    ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->delete();
    return redirect()->route('verGrupos', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)])->with('message', 'Registro eliminado correctamente');
  }


  public function avisoGrupoAgregado($rvoe, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    return view('avisoGrupoAgregado', compact('rvoe', 'vigencia'));
  }

  public function listaGrupo($rvoe, $vigencia, Request $request)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);

    $ciclo = $request->input('ciclo_escolar');
    $ciclos = ModeloCicloEscolar::get();
    $ciclo_actual = ModeloCicloEscolar::where('actual', '=', 1)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'grupo.fecha_ini',
      'grupo.fecha_fin',
      'turno.nombre_turno',
      'grupo.fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
      // ->join('plan_grupo','plan_grupo.vigencia','=','actualizacion_plan.vigencia')
      //->join('actualizacion_plan', 'actualizacion_plan.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', '=', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->where('ciclo_escolar.actual', '=', 1)
      ->ciclo($ciclo)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGrupos', compact('grupos', 'datos', 'ciclos', 'ciclo_actual'));
  }

  public function listaGrupoAnalista($rvoe, $clave_cct, $vigencia)
  {

    $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'turno.nombre_turno',
      'fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      // ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGruposAnalista', compact('grupos', 'datos', 'institucion'));
  }

  public function listarAlumnos($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo',
      'no_periodo'
    )
      ->where('clave_grupo', '=', $clave_grupo)->take(1)->first();

    $alumnos = Alumno::select(
      'alumno_inscripcion.matricula',
      'alumno.curp',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono',
      'alumno_inscripcion.status_inscripcion',
      'alumno_inscripcion.observaciones'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('alumno_plan', 'alumno_plan.curp', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo) // ->where('alumno.status_inscripcion', '=', '0')
      ->where('alumno_plan.no_periodo', '=', $grupo->no_periodo)
      ->where('alumno_plan.status', '=', 1)
      ->orderBy('alumno.curp', 'asc')
      ->paginate(10);
    //return $alumnos;
    if (sizeof($alumnos) == 0) {
      return redirect()->back()->with('message2', "No hay alumnos en este grupo");
    }
    return view('listarAlumnos', compact('alumnos', 'grupo', 'datos'));
  }
  public function listarAlumnosAnalista($clave_grupo)
  {
    $grupo = ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo'
    )
      ->where('clave_grupo', '=', $clave_grupo)
      ->get();

    $alumnos = Alumno::select(
      'alumno_inscripcion.matricula',
      'alumno.curp',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono',
      'alumno_inscripcion.status_inscripcion',
      'alumno_inscripcion.observaciones'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo) // ->where('alumno.status_inscripcion', '=', '0')
      ->orderBy('alumno.curp', 'asc')
      ->paginate(30);
    return view('listarAlumnosAnalista', compact('alumnos', 'grupo'));
  }

  public function formvalidarInscripcion($clave_grupo, $rvoe, $vigencia, $clave_cct)
  {
    $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    /*$datos = ModeloPlan::select(
      'rvoe',
      'nombre_plan',
      'id_nivel_educativo'
    )->where('rvoe', '=', $rvoe)->get();*/

    // return $datos ['id_nivel_educativo'];

    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)
      ->take(1)->first();
    $alumnos = Alumno::select(

      'alumno.curp',
      'alumno_inscripcion.matricula',
      'nombre',
      'apellido_paterno',
      'apellido_materno',

      'alumno_inscripcion.acta_nacimiento',
      'alumno_inscripcion.curp_doc',
      'alumno_inscripcion.certificado_secundaria',
      'alumno_inscripcion.certificado_bachillerato',
      'alumno_inscripcion.certificado_lic',
      'alumno_inscripcion.titulo',
      'alumno_inscripcion.cedula',
      'alumno_inscripcion.certificado_ma',
      'alumno_inscripcion.titulo_ma',
      'alumno_inscripcion.cedula_ma',
      'alumno_inscripcion.status_inscripcion'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('alumno_plan', 'alumno_plan.curp', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo)->where('alumno_inscripcion.status_inscripcion', '!=', '1')
      ->where('alumno_plan.no_periodo', '<', 2)
      //->where('alumno_inscripcion.status_inscripcion', '=', '0')
      // ->paginate(5);
      //return $datos;
      ->get();
    $nivel = $datos['id_nivel_educativo'];

    if (sizeof($alumnos) == 0) {
      return redirect()->route('verGruposAnalista', ['rvoe' => $rvoe, 'clave_cct' => $clave_cct, 'vigencia' => $vigencia])->with('message2', 'No hay alumnos para Validar');
    } else if ($alumnos[0] == null) {
      return redirect()->route('verGruposAnalista', ['rvoe' => $rvoe, 'clave_cct' => $clave_cct, 'vigencia' => $vigencia])->with('message2', 'No hay alumnos para Validar');
    }
    return view('formValidarInscripcion', compact('alumnos', 'grupo', 'nivel', 'clave_grupo', 'rvoe', 'datos', 'institucion'));
  }

  public function validarInscripcion(Request $var)
  {
    $nivel = $var->input("nivel");
    $clave_grupo = $var->input("clave_grupo");
    $rvoe = $var->input("rvoe");
    $curp = $var->input("curp");
    $vigencia = $var->input('vigencia');
    $clave_cct = $var->input('clave_cct');
    $matricula = $var->input("matricula");
    $observacionT = $var->input("observacionesT");
    $observaciones = $var->input("observaciones");
    //aqui validacion
    if ($observacionT == 0) {
      if ($nivel == 3) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_secundaria = $var->input('certificado_secundaria');
        $certificado_bachillerato = $var->input('certificado_bachillerato');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_secundaria' => $certificado_secundaria,
            'certificado_bachillerato' => $certificado_bachillerato,
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/

        // return route('validarInscripcion/'.$clave_grupo.'/'.$rvoe);//->with('message', 'Alumno Validado correctamente');
        return redirect()->route('validarInscripcion', ['clave_grupo' => $clave_grupo, 'rvoe' => $rvoe, 'vigencia' => $vigencia, 'clave_cct' => $clave_cct])->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 4 or $nivel == 5) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_lic = $var->input('certificado_lic');
        $titulo = $var->input('titulo');
        $cedula = $var->input('cedula');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_lic' => $certificado_lic,
            'titulo' => $titulo, 'cedula' => $cedula,
            'observaciones' => $observaciones
          ]);
        /* Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 6) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_ma = $var->input('certificado_ma');
        $titulo_ma = $var->input('titulo_ma');
        $cedula_ma = $var->input('cedula_ma');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_ma' => $certificado_ma,
            'titulo_ma' =>
            $titulo_ma, 'cedula_ma' => $cedula_ma,
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {

        $acta_nacimiento = $var->input("acta_nacimiento");
        $curpt = $var->input("curpt");
        $certificado_secundaria = $var->input("certificado_secundaria");
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_secundaria' => $certificado_secundaria,
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->route('validarInscripcion', [$clave_grupo, $rvoe])->with('message', 'Alumno Validado correctamente');
      }
    } else if ($observacionT == 1) {
      if ($nivel == 3) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_secundaria = $var->input('certificado_secundaria');
        $certificado_bachillerato = $var->input('certificado_bachillerato');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/

        // return route('validarInscripcion/'.$clave_grupo.'/'.$rvoe);//->with('message', 'Alumno Validado correctamente');
        return redirect()->route('validarInscripcion', ['clave_grupo' => $clave_grupo, 'rvoe' => $rvoe, 'vigencia' => $vigencia, 'clave_cct' => $clave_cct])->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 4 or $nivel == 5) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_lic = $var->input('certificado_lic');
        $titulo = $var->input('titulo');
        $cedula = $var->input('cedula');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /* Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 6) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_ma = $var->input('certificado_ma');
        $titulo_ma = $var->input('titulo_ma');
        $cedula_ma = $var->input('cedula_ma');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {

        $acta_nacimiento = $var->input("acta_nacimiento");
        $curpt = $var->input("curpt");
        $certificado_secundaria = $var->input("certificado_secundaria");
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->route('validarInscripcion', [$clave_grupo, $rvoe])->with('message', 'Alumno Validado correctamente');
      }
    }
  }


  public function ver_GpoDinamico()
  {
    return view('GrupoDinamico');
  }

  function insert(Request $request)
  {
    if ($request->ajax()) {
      $rules = array(
        'clave_grupo.*'  => 'required',
        'nombre_grupo.*'  => 'required',
        'no_semestre.*'  => 'required',
        'periodo_escolar.*'  => 'required',
        'clave_docente.*'  => 'required',
        'clave_asignatura.*'  => 'required',
        'turno.*'  => 'required'
      );

      $error = Validator::make($request->all(), $rules);
      if ($error->fails()) {
        return response()->json([
          'error'  => $error->errors()->all()
        ]);
      }

      $clave_grupo = $request->clave_grupo;
      $nombre_grupo = $request->nombre_grupo;
      $no_semestre = $request->no_semestre;
      $periodo_escolar = $request->periodo_escolar;
      $clave_docente = $request->clave_docente;
      $clave_asignatura = $request->clave_asignatura;
      $turno = $request->turno;
      //$rvoe = ModeloAsignatura::select('fk_rvoe')->where($clave_asignatura);

      for ($count = 0; $count < count($clave_grupo); $count++) {
        $data = array(
          'clave_grupo' => $clave_grupo[$count],
          'nombre_grupo'  => $nombre_grupo[$count],
          'no_semestre'  => $no_semestre[$count],
          'periodo_escolar'  => $periodo_escolar[$count],
          'clave_docente'  => $clave_docente[$count],
          'clave_asignatura'  => $clave_asignatura[$count],
          'turno' => $turno[$count]
        );
        $insert_data[] = $data;
      }

      return $insert_data;
      ModeloGrupo::insert($insert_data);
      return response()->json([
        'success'  => 'Datos añadidos correctamente'
      ]);
    }
  }


  function ver_asignaturas(Request $var)
  {
    $clave_institucion = auth()->user()->institucion;
    $asignatura = ModeloAsignatura::all();
    $docente['docente'] = ModeloDocente::all()->where('fk_clave_cct', '=', $clave_institucion);
    return view('GrupoDinamico', compact('asignatura'), $docente);
  }

  function ver_docente(Request $var)
  {
    //$consulta =   ModeloCarrera::get(['nombre']);
    //return $consulta;
    $docente = ModeloDocente::all();
    return view('GrupoDinamico', compact('docente'));
  }

  function vistaGrupoCalificar($rvoe, $vigencia, Request $request)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);

    $ciclo = $request->input('ciclo_escolar');
    $ciclos = ModeloCicloEscolar::get();

    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'turno.nombre_turno',
      'fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      // ->join('plan_grupo','plan_grupo.vigencia','=','actualizacion_plan.vigencia')
      //->join('actualizacion_plan', 'actualizacion_plan.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', '=', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->ciclo($ciclo)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGruposCalificar', compact('grupos', 'datos', 'ciclos'));
  }

  function vistaGrupoCalificarExtra($rvoe, $vigencia, Request $request)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);

    $ciclo = $request->input('ciclo_escolar');
    $ciclos = ModeloCicloEscolar::get();

    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'turno.nombre_turno',
      'fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      // ->join('plan_grupo','plan_grupo.vigencia','=','actualizacion_plan.vigencia')
      //->join('actualizacion_plan', 'actualizacion_plan.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', '=', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->ciclo($ciclo)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('vistaGruposCalificarExtra', compact('grupos', 'datos', 'ciclos'));
  }


  public function listarAlumnosCalificacion($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo',
      'no_periodo'
    )
      ->where('clave_grupo', '=', $clave_grupo)->take(1)->first();

    $alumnos = Alumno::select(
      'alumno_inscripcion.matricula',
      'alumno.curp',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono',
      'alumno_inscripcion.status_inscripcion',
      'alumno_inscripcion.observaciones'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('alumno_grupo_asignatura', 'alumno_grupo_asignatura.curp', '=', 'alumno_inscripcion.fk_curp_alumno')
      ->where('grupo.clave_grupo', '=', $clave_grupo) //->where('alumno_inscripcion.status_inscripcion', '=', '1')
      //->where('alumno_grupo_asignatura.status_aa', '=', 1)
      ->orderBy('alumno.curp', 'asc')
      ->distinct('alumno.curp')->get();
    //->paginate(10);

    if (sizeof($alumnos) == 0) {
      // return redirect()->back()->with('message2', 'Este grupo ya evaluó a sus alumnos ó no existen alumnos en este grupo');
      return redirect()->route('verGruposCalificar', ['rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)])->with('message2', 'Este grupo ya evaluó a sus alumnos ó no existen alumnos en este grupo');
    }
    return view('listarAlumnosCalificacion', compact('alumnos', 'grupo', 'datos'));
  }

  function alumnoverAsignaturasCa($rvoe, $vigencia, $curp, $clave_grupo)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $curp = decrypt($curp);
    $clave_grupo = decrypt($clave_grupo);
    $alumno = Alumno::join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')->where('curp', '=', $curp)->take(1)->first();
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $periodo = DB::table('tipo_periodo')->get();
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $materias = ModeloAsignatura::select(
      'asignatura.clave_asignatura',
      'asignatura.nombre_asignatura',
      'no_creditos',
      'tipo_asignatura',
      'tipo_asignatura.nombre_tipo_asignatura',
      'tipo_periodo.nombre_periodo',
      'tipo_periodo',
      'no_parciales',
      'asignatura.no_periodo'
    )
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('tipo_periodo', 'tipo_periodo.id', '=', 'asignatura.tipo_asignatura')
      ->join('tipo_asignatura', 'tipo_asignatura.id_tipo_asignatura', '=', 'asignatura.tipo_asignatura')
      ->where('plan_asignatura.rvoe', '=', $rvoe)->where('fecha_actualizacion', '=', $vigencia)
      ->orderBy('asignatura.no_periodo', 'ASC')->paginate(5);
    if ($materias->count() == 0) {
      return redirect()->back()->with('message2', 'Este Plan de Estudios no contiene materias, elija otra opcion');
    }
    return view('materiasCalifi', compact('materias', 'plan', 'vigencia', 'alumno', 'clave_grupo', 'grupo'));
  }
  function formvalidarAcreditacion()
  {
  }

  function verGruposAnalistaCalif($rvoe, $clave_cct, $vigencia)
  {

    $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'turno.nombre_turno',
      'fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      // ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGruposAnalistaValidarCalif', compact('grupos', 'datos', 'institucion'));
  }

  function menuAsignaturasCalif($clave_grupo, $no_periodo, $vigencia, $rvoe)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $clave_grupo = decrypt($clave_grupo);
    $no_periodo = decrypt($no_periodo);
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    //return $plan;
    $periodo = DB::table('tipo_periodo')->get();
    $asignaturas = ModeloAsignatura::select('alumno_grupo_asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('alumno_grupo_asignatura', 'alumno_grupo_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->where('alumno_grupo_asignatura.clave_grupo', '=', $clave_grupo) //->where('asignatura.no_periodo', '=', $no_periodo)
      ->where('alumno_grupo_asignatura.vigencia', '=', $vigencia)
      ->where('alumno_grupo_asignatura.rvoe', '=', $rvoe)
      ->where('asignatura.fk_rvoe', '=', $rvoe)
      ->where('asignatura.vigencia', '=', $vigencia)
      ->distinct('alumno_grupo_asignatura.clave_asignatura')->get();
    return view('menuAsignaturasCalif', compact('asignaturas', 'plan', 'clave_grupo', 'grupo'));
  }

  public function listarAlumnosRepro($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo',
      'no_periodo'
    )
      ->where('clave_grupo', '=', $clave_grupo)->take(1)->first();

    $alumnos = ModeloAluGpoAsig::select(
      'alumno_grupo_asignatura.curp',
      'alumno.nombre',
      'alumno_inscripcion.matricula',
      'alumno.apellido_paterno',
      'alumno.apellido_materno'
    )
      ->join('alumno', 'alumno.curp', '=', 'alumno_grupo_asignatura.curp')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('alumno_grupo_asignatura.observaciones', '!=', 1)
      ->where('alumno_grupo_asignatura.clave_grupo', '=', $clave_grupo)
      ->distinct()
      ->paginate(10);
    return view('listarAlumnosReprob', compact('alumnos', 'grupo', 'datos'));
  }

  public function calificacionNoOrdinaria($rvoe, $vigencia, $curp, $clave_grupo)
  {

    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $curp = decrypt($curp);
    $clave_grupo = decrypt($clave_grupo);
    $alumno = Alumno::where('curp', '=', $curp)->take(1)->first();
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $periodo = DB::table('tipo_periodo')->get();
    $materias = ModeloAsignatura::select(
      'asignatura.clave_asignatura',
      'asignatura.nombre_asignatura',
      'no_creditos',
      'tipo_asignatura',
      'tipo_asignatura.nombre_tipo_asignatura',
      'tipo_periodo.nombre_periodo',
      'tipo_periodo',
      'no_parciales',
      'asignatura.no_periodo'
    )
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('tipo_periodo', 'tipo_periodo.id', '=', 'asignatura.tipo_asignatura')
      ->join('tipo_asignatura', 'tipo_asignatura.id_tipo_asignatura', '=', 'asignatura.tipo_asignatura')
      ->where('plan_asignatura.rvoe', '=', $rvoe)->where('fecha_actualizacion', '=', $vigencia)
      ->orderBy('asignatura.no_periodo', 'ASC')->paginate(5);
    if ($materias->count() == 0) {
      return redirect()->back()->with('message2', 'Este Plan de Estudios no contiene materias, elija otra opcion');
    }
    return view('calificacionesParaActas', compact('materias', 'plan', 'vigencia', 'alumno', 'clave_grupo'));
  }

  function validarAcreditacion(Request $request)
  {
    $clave_grupo = $request->clave_grupo;
    $clave_asignatura = $request->clave_asignatura;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $array = $request->array;
    for ($i = 0; $i < sizeof($array); $i++) {
      ModeloAluGpoAsig::where('curp', '=', $array[$i][1])->where('clave_asignatura', '=', $clave_asignatura)
        ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
        ->update([
          "validado" => 1
        ]);
    }
    return response()->json($array[0][1]);
  }

  function acusesAcreditaciónPorAsignatura($clave_grupo, $rvoe, $clave_cct, $vigencia)
  {
    set_time_limit(300);
    $array = [];
    $nombre_usuario = auth()->user()->nombre_usuario;
    $apellido_paterno = auth()->user()->apellido_paterno;
    $apellido_materno = auth()->user()->apellido_materno;
    date_default_timezone_set('America/Mexico_City');
    $DateAndTime = date('d-m-Y h:i:s a', time());
    /*Si en el servidor principal no funciona, editar esta linea desde format hasta merge
    y modificar en la vista acusevalidacion inscripcion
    con lo siguiente data:image/svg+xml;base64*/
    $codigoQR = QrCode::format('png')->mergeString(Storage::get("public/cg2.png"), .9, true)->errorCorrection('H')->generate('Validado por: ' . $nombre_usuario . ' ' . $apellido_paterno . ' Fecha: ' . $DateAndTime);
    $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
    $plan = ModeloActualizarPlan::where('rvoe', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'fecha_ini',
      'fecha_fin',
      'turno.nombre_turno',
      'fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('grupo.clave_grupo', $clave_grupo)
      ->take(1)->first();

    $no_periodo = $grupo->no_periodo;
    $nivel = 3;
    $sq = 'select distinct aga.clave_asignatura, aga.validado, a.nombre_asignatura, a.no_periodo from alumno_grupo_asignatura as aga 
    inner join asignatura as a on a.clave_asignatura = aga.clave_asignatura
     where clave_grupo = "' . $clave_grupo . '" and aga.rvoe ="' . $rvoe . '"
      and aga.vigencia ="' . $vigencia . '" and a.fk_rvoe ="' . $rvoe . '" 
      and a.vigencia ="' . $vigencia . '" order by a.no_periodo desc';
    $asignaturas =  DB::select($sq);
    /* $asignaturas = ModeloAsignatura::select('alumno_grupo_asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('alumno_grupo_asignatura', 'alumno_grupo_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->where('alumno_grupo_asignatura.clave_grupo', '=', $clave_grupo)
      ->where('asignatura.no_periodo', '=', $no_periodo)
      ->where('alumno_grupo_asignatura.vigencia', '=', $vigencia)
      ->where('alumno_grupo_asignatura.rvoe', '=', $rvoe)
      ->where('asignatura.fk_rvoe', '=', $rvoe)
      ->where('asignatura.vigencia', '=', $vigencia)
      ->distinct('alumno_grupo_asignatura.clave_asignatura')->get();*/
    // return $asignaturas[0]->clave_asignatura;
    for ($i = 0; $i < sizeof($asignaturas); $i++) {
      $sql = 'select aga.curp,ai.matricula,a.nombre,a.apellido_paterno,a.apellido_materno,
      pl1,pl2,pl3,pl4,pl5,ordinario,final,promedio_final, aga.status_aa,aga.validado
       ,porcentaje_asistencia, fpl1,fpl2,fpl3,fpl4,fpl5,fordinario, aga.observaciones,
        oc.nombre_observaciones, d.nombre as ndocente, d.apellido_paterno as nap,
         d.apellido_materno as nam, ai.status_inscripcion, clave_asignatura from alumno_grupo_asignatura 
         as aga inner join alumno_inscripcion as ai on aga.curp = ai.fk_curp_alumno inner join 
         alumno as a on a.curp = aga.curp inner join docente as d on d.rfc = aga.rfc_docente
          inner join observaciones_calificacion as oc on oc.id_observaciones = aga.observaciones
           where clave_grupo = "' . $clave_grupo . '"
            and clave_asignatura = "' . $asignaturas[$i]->clave_asignatura . '" 
            and aga.vigencia = "' . $vigencia . '"
             and aga.rvoe = "' . $rvoe . '" order by aga.curp asc';
      $filas = DB::select($sql);
      //if (sizeof($filas) > 0) {
      $array[$i] = $filas;
      //  }
    }
    // return sizeof($array[4]);
    $tamaño = 2; //sizeof($filas);
    // return $asignaturas;
    // return response()->json($array[0][0]);
    // return view('acuseAcreditacion', compact('institucion', 'plan', 'grupo', 'nivel','array','asignaturas','codigoQR','tamaño'));
    $pdf = PDF::loadView('acuseAcreditacion', compact('institucion', 'plan', 'grupo', 'nivel', 'array', 'asignaturas', 'codigoQR', 'tamaño'))
      ->setPaper('a4', 'landscape');
    return  $pdf->stream('archivo.pdf');
    // $file = $pdf->output();
  }

  function vistaReporteSemestral($rvoe, $clave_grupo, $vigencia)
  {
    $rvoe = decrypt($rvoe);
    $clave_grupo = decrypt($clave_grupo);
    $vigencia = decrypt($vigencia);

    $datosUnidos = [];
    $dato = [];
    $arrayCurps = [];
    $sq = 'select distinct aga.clave_asignatura, aga.validado, a.nombre_asignatura, a.no_periodo from alumno_grupo_asignatura as aga 
    inner join asignatura as a on a.clave_asignatura = aga.clave_asignatura
     where clave_grupo = "' . $clave_grupo . '" and aga.rvoe ="' . $rvoe . '"
      and aga.vigencia ="' . $vigencia . '" and a.fk_rvoe ="' . $rvoe . '" 
      and a.vigencia ="' . $vigencia . '" order by a.no_periodo desc';
    $arrayMaterias =  DB::select($sq);
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $datosAlumno = ModeloAluGpoAsig::select('alumno_grupo_asignatura.curp', 'matricula', 'nombre', 'apellido_paterno', 'apellido_materno')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno_grupo_asignatura.curp')
      ->join('alumno', 'alumno.curp', '=', 'alumno_grupo_asignatura.curp')->where('alumno_grupo_asignatura.clave_grupo', '=', $clave_grupo)
      // ->where('alumno_inscripcion.status_inscripcion', '=', 1)
      ->distinct()->orderBy('curp')->get();
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    //return $arrayMaterias;
    /*para que salga en orden tomar el array de curps de datosAlumno*/
    for ($i = 0; $i < sizeof($datosAlumno); $i++) {
      $arrayCurps[$i] = $datosAlumno[$i]->curp;
    }
    for ($i = 0; $i < sizeof($arrayCurps); $i++) {
      for ($j = 0; $j < sizeof($arrayMaterias); $j++) {
        $dato[$j] = ModeloAluGpoAsig::select(
          'curp',
          'alumno_grupo_asignatura.clave_asignatura',
          'asignatura.nombre_asignatura',
          'promedio_final',
          'alumno_grupo_asignatura.observaciones',
          'observaciones_calificacion.nombre_observaciones',
          'alumno_inscripcion.status_inscripcion'
        )
          ->join('asignatura', 'asignatura.clave_asignatura', '=', 'alumno_grupo_asignatura.clave_asignatura')
          ->join('observaciones_calificacion', 'observaciones_calificacion.id_observaciones', '=', 'alumno_grupo_asignatura.observaciones')
          ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno_grupo_asignatura.curp')
          ->where('curp', '=', $arrayCurps[$i]) //->where('clave_grupo', '=', $clave_grupo)
          ->where('alumno_grupo_asignatura.rvoe', '=', $rvoe)
          ->where('alumno_grupo_asignatura.vigencia', '=', $vigencia)->where('alumno_grupo_asignatura.clave_asignatura', '=', $arrayMaterias[$j]->clave_asignatura)
          ->where('asignatura.fk_rvoe', '=', $rvoe)->where('asignatura.vigencia', '=', $vigencia)
          ->where('alumno_grupo_asignatura.clave_grupo', '=', $clave_grupo)
          // ->where('alumno_inscripcion.status_inscripcion', '=', 1)
          ->distinct()->orderBy('curp')->get();
        if (sizeof($dato[$j]) == 0) {
          $linea = new stdClass();
          $linea->curp = "";
          $linea->clave_asignatura = "";
          $linea->nombre_asignatura = "";
          $linea->promedio_final = "no aplica";
          $linea->observaciones = 1;
          $linea->nombre_observaciones = "";
          $linea->status_inscripcion = 1;
          $dato[$j][0] = $linea;
          // return $dato[$j][0]->observaciones;
        }
      }

      $datosUnidos[$i] = $dato;
    }
    // return $datosUnidos;
    return view('vistaAcreditacionSemestre', compact('arrayMaterias', 'datosUnidos', 'datosAlumno', 'plan', 'grupo'));
  }
  function reporteSemestral(Request $request)
  {
    $materias = $request->arrayMaterias;
    $alumnos = $request->arrayCurps;
    $clave_grupo =  $request->clave_grupo;
    $rvoe = $request->rvoe;
    $vigencia =  $request->vigencia;
    $datosUnidos = [];
    $dato = [];

    for ($i = 0; $i < sizeof($alumnos); $i++) {
      for ($j = 0; $j < sizeof($materias); $j++) {
        $dato[$j] = ModeloAluGpoAsig::select('curp', 'alumno_grupo_asignatura.clave_asignatura', 'asignatura.nombre_asignatura', 'promedio_final')
          ->join('asignatura', 'asignatura.clave_asignatura', '=', 'alumno_grupo_asignatura.clave_asignatura')
          ->where('curp', '=', $alumnos[$i])->where('clave_grupo', '=', $clave_grupo)
          ->where('alumno_grupo_asignatura.rvoe', '=', $rvoe)
          ->where('alumno_grupo_asignatura.vigencia', '=', $vigencia)->where('alumno_grupo_asignatura.clave_asignatura', '=', $materias[$j])
          ->where('asignatura.fk_rvoe', '=', $rvoe)->where('asignatura.vigencia', '=', $vigencia)->get();
      }
      $datosUnidos[$i] = $dato;
    }

    return response()->json($datosUnidos);
  }

  function verActa($curp, $clave_grupo, $rvoe, $vigencia)
  {
    $curp = decrypt($curp);
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $alumno = Alumno::join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('curp', '=', $curp)->take(1)->first();
    $datos = ModeloCalificacionesExtra::join('asignatura', 'asignatura.clave_asignatura', '=', 'calificaciones_extra.clave_asignatura')
      ->join('observaciones_calificacion', 'observaciones_calificacion.id_observaciones', '=', 'calificaciones_extra.observaciones')
      ->join('docente', 'docente.rfc', '=', 'calificaciones_extra.rfc_docente')
      ->where('curp', '=', $curp)
      ->where('clave_grupo', '=', $clave_grupo)->where('calificaciones_extra.rvoe', '=', $rvoe)
      ->where('calificaciones_extra.vigencia', '=', $vigencia)
      ->where('asignatura.fk_rvoe', '=', $rvoe)
      ->where('asignatura.vigencia', '=', $vigencia)->get();
    return view('vistaCalificacionesExtra', compact('plan', 'grupo', 'alumno', 'datos'));
  }

  function vistaGruposReinscripción($rvoe, $vigencia, Request $request)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);

    $ciclo = $request->input('ciclo_escolar');
    $ciclos = ModeloCicloEscolar::get();
    $ciclo_actual = ModeloCicloEscolar::where('actual', '=', 1)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'grupo.fecha_ini',
      'grupo.fecha_fin',
      'turno.nombre_turno',
      'grupo.fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
      // ->join('plan_grupo','plan_grupo.vigencia','=','actualizacion_plan.vigencia')
      //->join('actualizacion_plan', 'actualizacion_plan.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', '=', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->where('ciclo_escolar.actual', '=', 1)
      ->where('no_periodo', '>', 1)
      ->ciclo($ciclo)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGruposReinscripcion', compact('grupos', 'datos', 'ciclos', 'ciclo_actual'));
  }

  function vistaGrupoEquivalenciaRevalidacion($rvoe, $clave_cct, $vigencia)
  {
    $clave_cct = decrypt($clave_cct);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    $sql = 'select DISTINCT ie.clave_grupo, g.nombre_grupo, g.no_periodo, g.fecha_ini, g.fecha_fin, g.fk_clave_ciclo_escolar, g.id_turno, t.nombre_turno from alumno_inscripcion as ai INNER JOIN alumno_grupo_asignatura as aga on ai.fk_curp_alumno = aga.curp
    INNER JOIN inscripcion_equivalencia as ie on ie.fk_curp = ai.fk_curp_alumno
    INNER JOIN grupo as g on ie.clave_grupo = g.clave_grupo
    INNER JOIN plan_grupo as pg on pg.clave_grupo = ie.clave_grupo
    INNER JOIN turno as t on t.id_turno = g.id_turno
    where ai.`equivalencia/revalidacion` = 1 and pg.rvoe ="' . $rvoe . '" and  pg.vigencia ="' . $vigencia . '"';
    $grupos = DB::select($sql);
    // return $grupos;
    return view('gruposEquivalenciaRevalidacion', compact('grupos', 'datos', 'institucion'));
  }

  public function formvalidarInscripcionEquivalencia($clave_grupo, $rvoe, $vigencia, $clave_cct)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $clave_cct = decrypt($clave_cct);
    $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();

    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)
      ->take(1)->first();
    $alumnos = Alumno::select(

      'alumno.curp',
      'alumno_inscripcion.matricula',
      'nombre',
      'apellido_paterno',
      'apellido_materno',

      'alumno_inscripcion.acta_nacimiento',
      'alumno_inscripcion.curp_doc',
      'alumno_inscripcion.certificado_secundaria',
      'alumno_inscripcion.certificado_bachillerato',
      'alumno_inscripcion.certificado_lic',
      'alumno_inscripcion.titulo',
      'alumno_inscripcion.cedula',
      'alumno_inscripcion.certificado_ma',
      'alumno_inscripcion.titulo_ma',
      'alumno_inscripcion.cedula_ma',
      'alumno_inscripcion.status_inscripcion',
      'inscripcion_equivalencia.certificado_parcial',
      'inscripcion_equivalencia.equivalencia'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('inscripcion_equivalencia', 'inscripcion_equivalencia.fk_curp', '=', 'alumno_inscripcion.fk_curp_alumno')
      ->where('grupo.clave_grupo', '=', $clave_grupo)->where('alumno_inscripcion.status_inscripcion', '!=', '1')
      //->where('alumno_inscripcion.status_inscripcion', '=', '0')
      // ->paginate(5);
      //return $datos;
      ->get();
    $nivel = $datos['id_nivel_educativo'];

    if (sizeof($alumnos) == 0) {
      return redirect()->route('gruposEquivalencia', ['rvoe' => encrypt($rvoe), 'clave_cct' => encrypt($clave_cct), 'vigencia' => encrypt($vigencia)])->with('message2', 'No hay alumnos para Validar');
    } else if ($alumnos[0] == null) {
      return redirect()->route('gruposEquivalencia', ['rvoe' => encrypt($rvoe), 'clave_cct' => encrypt($clave_cct), 'vigencia' => encrypt($vigencia)])->with('message2', 'No hay alumnos para Validar');
    }
    return view('formValidarInscripcionEquivalencia', compact('alumnos', 'grupo', 'nivel', 'clave_grupo', 'rvoe', 'datos', 'institucion'));
  }

  public function validarAluEquivalencia($curp, $rvoe, $vigencia, $clave_cct, Request $request)
  {
    // $curp = $request->input('curp');
    $nivel = $request->input('nivel');
    $rvoe = $request->input('rvoe');
    $clave_grupo = $request->input('clave_grupo');
    $sql = 'select DISTINCT de.fk_clave_asignatura, a.nombre_asignatura, a.no_periodo, de.calificacion  from asignatura as a inner join detalle_equivalencia as de on a.clave_asignatura = de.fk_clave_asignatura
    where de.curp = "' . $curp . '" and a.fk_rvoe ="' . $rvoe . '" and a.vigencia="' . $vigencia . '"';
    $calificaciones = DB::select($sql);
    //return $calificaciones;
    $alumno = Alumno::select(
      'alumno.curp',
      'alumno_inscripcion.matricula',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'sexo',
      'correo',
      'telefono',
      'alumno_inscripcion.curp_doc',
      'alumno_inscripcion.acta_nacimiento',
      'alumno_inscripcion.certificado_secundaria',
      'alumno_inscripcion.certificado_bachillerato',
      'alumno_inscripcion.certificado_lic',
      'alumno_inscripcion.titulo',
      'alumno_inscripcion.cedula',
      'alumno_inscripcion.certificado_ma',
      'alumno_inscripcion.titulo_ma',
      'inscripcion_equivalencia.certificado_parcial',
      'inscripcion_equivalencia.equivalencia',
      'folio_equivalencia'
    )
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('inscripcion_equivalencia', 'inscripcion_equivalencia.fk_curp', '=', 'alumno.curp')
      ->where('alumno.curp', '=', $curp)->take(1)->first();
    return view('alumnoValidarEquivalencia', compact('alumno', 'nivel', 'clave_grupo', 'rvoe', 'vigencia', 'clave_cct', 'calificaciones'));
  }

  public function validarInscripcionEquivalencia(Request $var)
  {
    $nivel = $var->input("nivel");
    $clave_grupo = $var->input("clave_grupo");
    $rvoe = $var->input("rvoe");
    $curp = $var->input("curp");
    $vigencia = $var->input('vigencia');
    $clave_cct = $var->input('clave_cct');
    $matricula = $var->input("matricula");
    $observacionT = $var->input("observacionesT");
    $observaciones = $var->input("observaciones");
    //aqui validacion
    if ($observacionT == 0) {
      if ($nivel == 3) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_secundaria = $var->input('certificado_secundaria');
        $certificado_bachillerato = $var->input('certificado_bachillerato');
        $certificado_parcial = $var->input('certificado_parcial');
        $equivalencia = $var->input('equivalencia');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_secundaria' => $certificado_secundaria,
            'certificado_bachillerato' => $certificado_bachillerato,
            'observaciones' => $observaciones
          ]);

        ModeloInsEquivalencia::where('fk_curp', '=', $curp)
          ->update([
            'certificado_parcial' => $certificado_parcial,
            'equivalencia' => $equivalencia
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/

        // return route('validarInscripcion/'.$clave_grupo.'/'.$rvoe);//->with('message', 'Alumno Validado correctamente');
        return redirect()->route('validarInscripcionEquivalencia', ['clave_grupo' => encrypt($clave_grupo), 'rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia), 'clave_cct' => encrypt($clave_cct)])->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 4 or $nivel == 5) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_lic = $var->input('certificado_lic');
        $titulo = $var->input('titulo');
        $cedula = $var->input('cedula');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_lic' => $certificado_lic,
            'titulo' => $titulo, 'cedula' => $cedula,
            'observaciones' => $observaciones
          ]);
        /* Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 6) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_ma = $var->input('certificado_ma');
        $titulo_ma = $var->input('titulo_ma');
        $cedula_ma = $var->input('cedula_ma');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_ma' => $certificado_ma,
            'titulo_ma' =>
            $titulo_ma, 'cedula_ma' => $cedula_ma,
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {

        $acta_nacimiento = $var->input("acta_nacimiento");
        $curpt = $var->input("curpt");
        $certificado_secundaria = $var->input("certificado_secundaria");
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'status_inscripcion' => 1,
            'acta_nacimiento' => $acta_nacimiento,
            'curp_doc' => $curpt,
            'certificado_secundaria' => $certificado_secundaria,
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->route('validarInscripcionEquivalencia', [$clave_grupo, $rvoe])->with('message', 'Alumno Validado correctamente');
      }
    } else if ($observacionT == 1) {
      if ($nivel == 3) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_secundaria = $var->input('certificado_secundaria');
        $certificado_bachillerato = $var->input('certificado_bachillerato');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/

        // return route('validarInscripcion/'.$clave_grupo.'/'.$rvoe);//->with('message', 'Alumno Validado correctamente');
        return redirect()->route('validarInscripcionEquivalencia', ['clave_grupo' => encrypt($clave_grupo), 'rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia), 'clave_cct' => encrypt($clave_cct)])->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 4 or $nivel == 5) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_lic = $var->input('certificado_lic');
        $titulo = $var->input('titulo');
        $cedula = $var->input('cedula');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /* Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 6) {
        $acta_nacimiento = $var->input('acta_nacimiento');
        $curpt = $var->input('curpt');
        $certificado_ma = $var->input('certificado_ma');
        $titulo_ma = $var->input('titulo_ma');
        $cedula_ma = $var->input('cedula_ma');
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->back()->with('message', 'Alumno Validado correctamente');
      } else if ($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10) {

        $acta_nacimiento = $var->input("acta_nacimiento");
        $curpt = $var->input("curpt");
        $certificado_secundaria = $var->input("certificado_secundaria");
        ModeloAlumnoInscripcion::where('fk_curp_alumno', '=', $curp)
          ->update([
            'observaciones' => $observaciones
          ]);
        /*Alumno::where('curp', '=', $curp)
        ->update([
          'matricula' => $matricula
        ]);*/
        return redirect()->route('validarInscripcionEquivalencia', [$clave_grupo, $rvoe])->with('message', 'Alumno Validado correctamente');
      }
    }
  }

  function verAlumnosParaReinscripcion($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $consulta = 'select ap.curp, ap.matricula, a.nombre, a.apellido_paterno, a.apellido_materno from 
    alumno_plan as ap INNER JOIN alumno as a on a.curp= ap.curp where rvoe = "' . $rvoe . '" and vigencia = "' . $vigencia . '" 
    and not EXISTS (SELECT null  from alumno_grupo as ag 
    INNER JOIN grupo as g on g.clave_grupo = ag.clave_grupo WHERE ap.curp = ag.curp  and g.no_periodo =' . $grupo->no_periodo . ' 
    ) and ap.no_periodo =' . $grupo->no_periodo;
    $alumnos = DB::select($consulta);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    return view('alumnosParaReinscripcion', compact('alumnos', 'datos', 'grupo'));
  }

  function cargaReinscripcion(Request $request)
  {
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $clave_grupo = $request->clave_grupo;
    $array = $request->array;

    for ($i = 0; $i < sizeof($array); $i++) {
      if ($array[$i][0] == 1) {
        ModeloAlumGpo::create([
          'curp' => $array[$i][2],
          'clave_grupo' => $clave_grupo
        ]);
      }
    }
    $link = 'http://127.0.0.1:8000/listaAlumnosReinscritos/' . encrypt($clave_grupo) . '/' . encrypt($rvoe) . '/' . encrypt($vigencia);

    return response()->json(["link" => $link]);
  }

  function listaAlumnosReinscritos($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $alumnos = Alumno::select(
      'alumno_inscripcion.matricula',
      'alumno.curp',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono',
      'alumno_inscripcion.status_inscripcion',
      'alumno_inscripcion.observaciones'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo) // ->where('alumno.status_inscripcion', '=', '0')
      ->orderBy('alumno.curp', 'asc')->get();
    return view('listaAlumnosReinscripcion', compact('grupo', 'datos', 'alumnos'));
  }

  function removerAlumnoGrupo($curp, $rvoe, $vigencia, $clave_grupo)
  {
    $curp = decrypt($curp);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $clave_grupo = decrypt($clave_grupo);
    ModeloAlumGpo::where('curp', '=', $curp)
      ->where('clave_grupo', '=', $clave_grupo)
      ->delete();

    return redirect()->back()->with('message', 'Alumno Eliminado Correctamente del Grupo');
  }

  function cargaAsignaturasReinscripcion($curp, $rvoe, $vigencia, $clave_grupo)
  {
    $curp = decrypt($curp);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $clave_grupo = decrypt($clave_grupo);
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $no_periodo = $grupo->no_periodo;
    $alumno = Alumno::join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->where('curp', '=', $curp)->take(1)->first();
    $sql = 'select   t1.clave_asignatura,t1.nombre_asignatura, t1.no_periodo, null as a
    FROM asignatura t1
   WHERE NOT EXISTS (SELECT NULL
                       FROM alumno_grupo_asignatura t2
                      WHERE t2.clave_asignatura = t1.clave_asignatura and curp = "' . $curp . '")  and t1.fk_rvoe = "' . $rvoe . '" and t1.vigencia ="' . $vigencia . '" and no_periodo <=' . $no_periodo . ' ';
    $asignaturas = DB::select($sql);
    $sql2 = 'select  aga.clave_asignatura, a.nombre_asignatura, a.no_periodo, saa.nombre_status_aa as a
    from alumno_grupo_asignatura as aga INNER JOIN
     asignatura as a on aga.clave_asignatura
      = a.clave_asignatura 
      INNER JOIN status_alumno_asignatura as saa
      on aga.status_aa = saa.id_status_aa
      where curp = "' . $curp . '"
       and a.fk_rvoe="' . $rvoe . '" and a.vigencia ="' . $vigencia . '"
        and aga.rvoe = "' . $rvoe . '" and aga.vigencia = "' . $vigencia . '" and aga.status_aa=3';
    //return $asignaturas ;
    $rastrea = array();
    for ($i = 0; $i < sizeof($asignaturas); $i++) {
      $seriada = ModeloAsignaturaSeriacion::where('clave_asignatura', '=', $asignaturas[$i]->clave_asignatura)->get();
      if (sizeof($seriada) > 0) {

        $sql3 = 'select  aga.clave_asignatura, a.nombre_asignatura, a.no_periodo, saa.nombre_status_aa as a
        from alumno_grupo_asignatura as aga INNER JOIN
         asignatura as a on aga.clave_asignatura
          = a.clave_asignatura 
          INNER JOIN status_alumno_asignatura as saa
          on aga.status_aa = saa.id_status_aa
          where curp = "' . $curp . '"
           and a.fk_rvoe="' . $rvoe . '" and a.vigencia ="' . $vigencia . '"
            and aga.rvoe = "' . $rvoe . '" and aga.vigencia = "' . $vigencia . '" 
            and aga.clave_asignatura ="' . $seriada[0]->clave_seriacion . '" and aga.status_aa=3';
        $reprobada = DB::select($sql3);
        if (sizeof($reprobada) > 0) {

          foreach ($asignaturas as $key => $objeto) {
            if ($objeto->clave_asignatura === $seriada[0]->clave_asignatura) {
              unset($asignaturas[$key]);
              $rastrea[] = $key;
            }
          }
        }
      }
    }
    $tamañoAsignatura = sizeof($asignaturas);
    $asignaturasReprobadas = DB::select($sql2);
    $tamañoRepro = sizeof($asignaturasReprobadas);
    if ($tamañoRepro > 0) {
      for ($i = 0; $i < $tamañoRepro; $i++) {
        $asignaturas[$tamañoAsignatura + $i] = $asignaturasReprobadas[$i];
      }
    }
    return view('cargaAsignaturasReinscripcion', compact('plan', 'grupo', 'alumno', 'asignaturas'));
  }

  function cargaAsignaturasR(Request $request)
  {
    $curp = $request->curp;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $clave_grupo = $request->clave_grupo;
    $array = $request->array;
    for ($i = 0; $i < sizeof($array); $i++) {
      if ($array[$i][0] == 1) {
        $valor =  ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][2])
          ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('status_aa', '=', 3)->delete();
        if ($valor) {
          ModeloAluGpoAsig::create([
            'curp' => $curp,
            'clave_grupo' => $clave_grupo,
            'clave_asignatura' => $array[$i][2],
            'rvoe' => $rvoe,
            'vigencia' => $vigencia,

            'status_aa' => 5

          ]);
        } else {
          ModeloAluGpoAsig::create([
            'curp' => $curp,
            'clave_grupo' => $clave_grupo,
            'clave_asignatura' => $array[$i][2],
            'rvoe' => $rvoe,
            'vigencia' => $vigencia,
            'status_aa' => 1
          ]);
        }
      }
    }

    return response()->json("Éxito");
  }

  function vistaGruposBajaAlumnos($rvoe, $vigencia, Request $request)
  {
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);

    $ciclo = $request->input('ciclo_escolar');
    $ciclos = ModeloCicloEscolar::get();
    $ciclo_actual = ModeloCicloEscolar::where('actual', '=', 1)->take(1)->first();
    $datos = ModeloActualizarPlan::select(
      'nombre_plan',
      'rvoe',
      'actualizacion_plan.id_turno',
      'turno.nombre_turno',
      'actualizacion_plan.id_tipo_nivel',
      'nivel_educativo.nombre_nivel_educativo',
      'id_duracion',
      'actualizacion_plan.vigencia'
    )
      ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
      ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
      ->where('rvoe', '=', $rvoe)->where('actualizacion_plan.vigencia', '=', $vigencia)->take(1)->first();
    //
    $grupos = ModeloGrupo::select(
      'grupo.clave_grupo',
      'nombre_grupo',
      'no_periodo',
      'grupo.fecha_ini',
      'grupo.fecha_fin',
      'turno.nombre_turno',
      'grupo.fk_clave_ciclo_escolar'
    )
      ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
      ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
      // ->join('plan_grupo','plan_grupo.vigencia','=','actualizacion_plan.vigencia')
      //->join('actualizacion_plan', 'actualizacion_plan.rvoe', '=', 'plan_grupo.rvoe')
      ->join('turno', 'turno.id_turno', '=', 'grupo.id_turno')
      ->where('plan_grupo.rvoe', '=', $rvoe)->where('plan_grupo.vigencia', '=', $vigencia)
      ->where('ciclo_escolar.actual', '=', 1)
      ->ciclo($ciclo)
      ->paginate(5);
    // $nivel=$datos[0][''];
    //return $datos;
    return view('verGruposBajaAlumnos', compact('grupos', 'datos', 'ciclos', 'ciclo_actual'));
  }

  function listarAlumnosBaja($clave_grupo, $rvoe, $vigencia)
  {
    $clave_grupo = decrypt($clave_grupo);
    $rvoe = decrypt($rvoe);
    $vigencia = decrypt($vigencia);
    $datos = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $grupo = ModeloGrupo::select(
      'clave_grupo',
      'nombre_grupo',
      'no_periodo'
    )
      ->where('clave_grupo', '=', $clave_grupo)->take(1)->first();

    $alumnos = Alumno::select(
      'alumno_inscripcion.matricula',
      'alumno.curp',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono',
      'alumno_inscripcion.status_inscripcion',
      'alumno_inscripcion.observaciones'
    )
      ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
      ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
      ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('alumno_plan', 'alumno_plan.curp', '=', 'alumno.curp')
      ->where('grupo.clave_grupo', '=', $clave_grupo) // ->where('alumno.status_inscripcion', '=', '0')
      ->where('alumno_plan.status', '=', 1)
      ->orderBy('alumno.curp', 'asc')
      ->paginate(10);

    if (sizeof($alumnos) == 0) {
      return redirect()->back()->with('message2', "No hay alumnos en este grupo");
    }
    return view('listarAlumnosBaja', compact('alumnos', 'grupo', 'datos'));
  }

  function bajaAlumno(Request $request)
  {
    $curp = $request->curp;
    $clave_grupo = $request->clave_grupo;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $tipo = $request->tipo;
    if ($tipo == 1) {
      ModeloAlumnoPlan::where('curp', '=', $curp)
        ->update([
          'status' => 2
        ]);
    } else {
      ModeloAlumnoPlan::where('curp', '=', $curp)
        ->update([
          'status' => 3
        ]);
    }

    return redirect()->back()->with('message', "Cambios realizados");
  }

  function validarSemestre(Request $request)
  {
    $array = $request->array;
    $clave_grupo = $request->clave_grupo;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    for ($i = 0; $i < sizeof($array); $i++) {
      $dato = ModeloAlumnoPlan::where('curp', '=', $array[$i][1])->where('rvoe', '=', $rvoe)
        ->where('vigencia', '=', $vigencia)->take(1)->first();
      ModeloAlumnoPlan::where('curp', '=', $array[$i][1])->where('rvoe', '=', $rvoe)
        ->where('vigencia', '=', $vigencia)
        ->update(['no_periodo' => $dato->no_periodo + 1]);
    }
    $link = 'http://127.0.0.1:8000/gruposValidarCalificacion/' . $clave_grupo . '/' . $rvoe . '/' . $vigencia;

    return response()->json(["link" => $link]);
  }
}
