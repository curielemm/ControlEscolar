<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\Materia;
use App\Models\ModeloInstitucion;
use App\Models\ModeloPlan;
use App\Models\ModeloPlanAsig;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAluGpoAsig;
use App\Models\ModeloAsignatura;
use App\Models\ModeloDetalleEquiv;
use App\Models\ModeloDocente;
use App\Models\ModeloGrupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationRuleParser;
use Illuminate\Validation\Rule as ValidationRule;



use Validator;

class ControllerMateria extends Controller
{

  public function ver_formularioMateria()
  {
    return view('insertarMateria');
  }

  public function ver_formularioMateriaMSU()
  {
    return view('insertarMateriaMSU');
  }
  public function ver_formularioMateriaCPT()
  {
    return view('insertarMateriaCPT');
  }

  public function ver_materiasDinamico()
  {
    return view('MateriasDinamico');
  }

  public function ver_selects(Request $var)
  {

    $fk_rvoe = $var->input('fk_rvoe');


    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '1')->orderBy('created_at', 'desc')->take(1)->get();

    $plan = ModeloPlan::select('nombre_plan', 'rvoe')->where('id_tipo_nivel', '1')->orderBy('created_at', 'desc')->take(1)->get();

    $asignatura = Materia::select('asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_asignatura.rvoe')->where('fk_rvoe', '=', $fk_rvoe)
      ->paginate(5);


    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('insertarMateria')->with(compact('escuela', 'plan', 'asignatura'));
  }

  public function ver_selectsMsu(Request $var)
  {

    $fk_rvoe = $var->input('fk_rvoe');


    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '2')->orderBy('created_at', 'desc')->take(1)->get();

    $plan = ModeloPlan::select('nombre_plan', 'rvoe')->where('id_tipo_nivel', '2')->orderBy('created_at', 'desc')->take(1)->get();

    $asignatura = Materia::select('asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_asignatura.rvoe')->where('fk_rvoe', '=', $fk_rvoe)
      ->paginate(5);

    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('insertarMateriaMSU')->with(compact('escuela', 'plan', 'asignatura'));
  }

  public function ver_selectsCpt(Request $var)
  {

    $fk_rvoe = $var->input('fk_rvoe');


    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '3')->orderBy('created_at', 'desc')->take(1)->get();

    $plan = ModeloPlan::select('nombre_plan', 'rvoe')->where('id_tipo_nivel', '3')->orderBy('created_at', 'desc')->take(1)->get();

    $asignatura = Materia::select('asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_asignatura.rvoe')->where('fk_rvoe', '=', $fk_rvoe)
      ->paginate(5);


    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('insertarMateriaCPT')->with(compact('escuela', 'plan', 'asignatura'));
  }

  public function inserMateria(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    return redirect()->to('avisoMateria');
    //return redirect('/');

  }


  public function inserMateriaMSU(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    return redirect()->to('avisoMateriaMSU');
    //return redirect('/');

  }


  public function inserMateriaCPT(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    return redirect()->to('avisoMateriaCPT');
    //return redirect('/');

  }

  public function listarMaterias()
  {
    $datos['materia'] = Materia::paginate(10);
    return view('listarMaterias', $datos);
  }

  public function listMatCtrl($rvoe, $vigencia)
  {
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
    return view('materiasListCtrl', compact('materias', 'plan', 'vigencia'));
  }

  public function listMat($rvoe, $vigencia)
  {

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
    return view('materiasList', compact('materias', 'plan', 'vigencia'));
  }

  public function consultaAjax4(Request $request)
  {
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    //$union = [];
    // $datos = 'datos';
    /*$materias = ModeloAsignatura::selectRaw(
      'asignatura.clave_asignatura,
      asignatura.nombre_asignatura,
      no_creditos,
      tipo_asignatura,
      tipo_asignatura.nombre_tipo_asignatura,
      tipo_periodo.nombre_periodo,
      tipo_periodo.comun,
      no_parciales,
      asignatura.no_periodo,(select max(a.no_periodo) from asignatura as a inner join plan_asignatura as pa on pa.clave_asignatura = a.clave_asignatura where pa.rvoe ="' . $rvoe . '" and pa.fecha_actualizacion ="' . $vigencia . '") as numeros'
    )
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('tipo_periodo', 'tipo_periodo.id', '=', 'asignatura.tipo_asignatura')
      ->join('tipo_asignatura', 'tipo_asignatura.id_tipo_asignatura', '=', 'asignatura.tipo_asignatura')
      ->where('plan_asignatura.rvoe', '=', $rvoe)->where('fecha_actualizacion', '=', $vigencia)
      ->orderBy('asignatura.no_periodo', 'ASC')->get();*/

    $materias = ModeloAsignatura::selectRaw(
      'asignatura.clave_asignatura,
        asignatura.nombre_asignatura,
        no_creditos,
        tipo_asignatura,
        tipo_asignatura.nombre_tipo_asignatura,
        tipo_periodo.nombre_periodo,
        tipo_periodo.comun,
        no_parciales,
        asignatura.no_periodo,(select max(no_periodo) from asignatura  where fk_rvoe ="' . $rvoe . '" and vigencia ="' . $vigencia . '") as numeros'
    )
      // ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('tipo_periodo', 'tipo_periodo.id', '=', 'asignatura.tipo_periodo')
      ->join('tipo_asignatura', 'tipo_asignatura.id_tipo_asignatura', '=', 'asignatura.tipo_asignatura')
      ->where('fk_rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)
      ->orderBy('asignatura.no_periodo', 'ASC')->get();
    // $union[0] = $materias;
    //$union[1] = $datos;
    return response()->json($materias);
  }

  function consultajaxT(Request $request)
  {
    $clave_asignatura = $request->clave_materia;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $clave_grupo = $request->clave_grupo;
    $union = [];
    $materia = ModeloAsignatura::where('clave_asignatura', '=', $clave_asignatura)
      ->where('fk_rvoe', '=', $rvoe)
      ->where('vigencia', '=', $vigencia)->get();
    $sql2 = 'select aga.curp,ai.matricula,a.nombre,a.apellido_paterno,a.apellido_materno,pl1,pl2,pl3,pl4,pl5,ordinario,final,promedio_final, aga.status_aa,aga.validado ,porcentaje_asistencia, fpl1,fpl2,fpl3,fpl4,fpl5,fordinario, ocl.nombre_observaciones,ai.status_inscripcion from alumno_grupo_asignatura as aga inner join alumno_inscripcion as ai on aga.curp = ai.fk_curp_alumno inner join alumno as a on a.curp = aga.curp inner join observaciones_calificacion as ocl on ocl.id_observaciones = aga.observaciones  where  clave_grupo = "' . $clave_grupo . '" and clave_asignatura = "' . $clave_asignatura . '" and aga.vigencia = "' . $vigencia . '" and aga.rvoe = "' . $rvoe . '"  order by aga.curp asc';
    $filas2 = DB::select($sql2);
    $sql = 'select aga.curp,ai.matricula,a.nombre,a.apellido_paterno,a.apellido_materno,pl1,pl2,pl3,pl4,pl5,ordinario,final,promedio_final, aga.status_aa,aga.validado ,porcentaje_asistencia, fpl1,fpl2,fpl3,fpl4,fpl5,fordinario, d.nombre as ndocente, d.apellido_paterno as nap, d.apellido_materno as nam, ocl.nombre_observaciones, ai.status_inscripcion from alumno_grupo_asignatura as aga inner join alumno_inscripcion as ai on aga.curp = ai.fk_curp_alumno inner join alumno as a on a.curp = aga.curp inner join docente as d on d.rfc = aga.rfc_docente inner join observaciones_calificacion as ocl on ocl.id_observaciones = aga.observaciones  where clave_grupo = "' . $clave_grupo . '" and clave_asignatura = "' . $clave_asignatura . '" and aga.vigencia = "' . $vigencia . '" and aga.rvoe = "' . $rvoe . '" order by aga.curp asc';
    $filas = DB::select($sql);
    $valor = false;
    //primer for
    if (sizeof($filas2) > 0) {
      for ($i = 0; $i < sizeof($filas2); $i++) {
        if ($filas2[$i]->status_aa == 1) {
          $valor = false;
          break;
        } else if ($filas2[$i]->validado == 1) {
          $valor = true;
          break;
        }
      }
    } else {
      $valor = false;
    }

    //segundo for de evaluacion
    if (sizeof($filas) === sizeof($filas2)) {
      if (sizeof($filas) > 0) {
        for ($i = 0; $i < sizeof($filas); $i++) {
          if ($filas[$i]->status_aa == 1) {
            $filas = "Proceso de Captura de Calificación No Completado";
            break;
          } else if ($filas[$i]->validado == 1) {
            $filas = "Asignatura Validada";
            break;
          }
        }
      } else {
        $filas = "Proceso de Captura de Calificación No Completado";
      }
    } else {
      $filas = "Proceso de Captura de Calificación No Completado";
    }
    $val = 0;
    /* for ($i = 0; $i < sizeof($filas); $i++) {
      if ($filas[$i]->validado == 1) {
        $val++;
      }
    }
    $acabado = 0;
    if ($val == sizeof($filas) - 1) {
      $acabado = 1;
    */
    $union[0] = $materia;
    $union[1] = $filas;
    // $union[2] = $acabado;
    return response()->json($union);
  }

  function completado(Request $request)
  {
    $rvoe = $request->rvoe;
    $clave_grupo = $request->clave_grupo;
    $vigencia = $request->vigencia;
    $valor = 0;;
    $sql = 'select clave_asignatura, validado from alumno_grupo_asignatura where clave_grupo = "' . $clave_grupo . '" and rvoe ="' . $rvoe . '" and vigencia ="' . $vigencia . '" and validado is null';
    $filas = DB::select($sql);
    if (sizeof($filas) == 0) {
      $valor = 1;
    }
    //aqui contamos si las materias del grupo ya han sido validadas
    return response()->json($valor);
  }

  public function viewConsAlu_asig($rvoe, $vigencia, $curp, $clave_grupo)
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
    return view('asignaturasAlumnos', compact('materias', 'plan', 'vigencia', 'alumno', 'clave_grupo'));
  }

  public function consultaAlu_Asig(Request $request)
  {
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $curp = $request->curp;
    $clave_grupo = $request->clave_grupo;
    $union = [];
    $aluMat = ModeloAluGpoAsig::where('curp', '=', $curp)
      // ->where('clave_grupo', '=', $clave_grupo)
      ->where('rvoe', '=', $rvoe)
      ->where('vigencia', '=', $vigencia)->get();
    $materias = ModeloAsignatura::selectRaw(
      'asignatura.clave_asignatura,
        asignatura.nombre_asignatura,
        no_creditos,
        tipo_asignatura,
        tipo_asignatura.nombre_tipo_asignatura,
        tipo_periodo.nombre_periodo,
        tipo_periodo.comun,
        no_parciales,
        asignatura.no_periodo,(select max(no_periodo) from asignatura  where fk_rvoe ="' . $rvoe . '" and vigencia ="' . $vigencia . '") as numeros'
    )
      ->join('tipo_periodo', 'tipo_periodo.id', '=', 'asignatura.tipo_periodo')
      ->join('tipo_asignatura', 'tipo_asignatura.id_tipo_asignatura', '=', 'asignatura.tipo_asignatura')
      //->join('alumno_grupo_asignatura','')
      ->where('fk_rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)
      ->orderBy('asignatura.no_periodo', 'ASC')->get();
    $union[0] = $aluMat;
    $union[1] = $materias;
    return response()->json($union);
  }

  public function materiasAluGpoAsig(Request $request)
  {
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $curp = $request->curp;
    $clave_grupo = $request->clave_grupo;
    $union = [];
    $clave_cct = auth()->user()->institucion;
    $aluMat = ModeloAluGpoAsig::where('curp', '=', $curp)
      ->where('clave_grupo', '=', $clave_grupo)
      ->where('alumno_grupo_asignatura.rvoe', '=', $rvoe)
      ->where('alumno_grupo_asignatura.vigencia', '=', $vigencia)
      ->take(1)->first();
    $sql = 'select aga.clave_asignatura, a.nombre_asignatura, 
    aga.pl1, aga.pl2, aga.pl3, aga.pl4, aga.pl5, aga.ordinario, aga.final, aga.promedio_final, 
    porcentaje_asistencia from asignatura as a INNER JOIN 
    alumno_grupo_asignatura as aga on (a.clave_asignatura = aga.clave_asignatura
     and a.fk_rvoe = aga.rvoe and a.vigencia = aga.vigencia and aga.clave_grupo = "'.$clave_grupo.'") where aga.curp = "' . $curp . '" 
     and aga.rvoe ="' . $rvoe . '" and aga.vigencia = "' . $vigencia . '" 
     and aga.status_aa = 1 or aga.status_aa = 5 ';
    $consul = DB::select($sql);
    $tamañoConsul = sizeof($consul);
    if ($tamañoConsul > 0) {
      $valor = $aluMat->clave_asignatura;
    
    $parciales = ModeloAsignatura::select('no_parciales')->where('clave_asignatura', '=', $valor)
      ->where('fk_rvoe', '=', $rvoe)
      ->where('vigencia', '=', $vigencia)->take(1)->first();
    //  $sql2 = 'select d.nombre, d.apellido_paterno, d.apellido_materno from docente as d inner join institucion_docente as id on d.rfc = id.rfc where id.clave_cct ="' . $clave_cct . '"';
    $sql2 = 'select d.rfc, d.nombre, d.apellido_paterno, d.apellido_materno from docente as d INNER JOIN institucion_docente as id ON id.rfc = d.rfc where clave_cct = "' . $clave_cct . '"';
    $docente = DB::select($sql2);

    $sql3 = 'select * from observaciones_calificacion';
    $obse = DB::select($sql3);
  
      $union[0] = $consul;
      $union[1] = $parciales;
      $union[2] = $docente;
      $union[3] = $obse;
    } else {
      $union[0] = "No hay Registros";
    }

    return response()->json($union);
  }

  function materiasNoOrdinario(Request $request)
  {
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $curp = $request->curp;
    $clave_grupo = $request->clave_grupo;
    $union = [];
    $clave_cct = auth()->user()->institucion;
    $alumMate = 'select distinct aga.clave_asignatura, a.nombre_asignatura, aga.promedio_final, aga.observaciones, oc.nombre_observaciones,aga.rfc_docente, d.nombre, d.apellido_paterno, d.apellido_materno FROM alumno_grupo_asignatura as aga INNER JOIN asignatura as a on aga.clave_asignatura = a.clave_asignatura inner join docente as d on d.rfc = aga.rfc_docente inner join observaciones_calificacion as oc on aga.observaciones =  oc.id_observaciones where aga.curp = "' . $curp . '" and aga.clave_grupo = "' . $clave_grupo . '" and a.fk_rvoe="' . $rvoe . '" and a.vigencia ="' . $vigencia . '" and  aga.observaciones !=1;';
    $alum = DB::select($alumMate);
    $sql2 = 'select d.rfc, d.nombre, d.apellido_paterno, d.apellido_materno from docente as d INNER JOIN institucion_docente as id ON id.rfc = d.rfc where clave_cct = "' . $clave_cct . '"';
    $docente = DB::select($sql2);
    $union[0] = $alum;
    $union[1] = $docente;
    return response()->json($union);
  }

  public function avisoMat()
  {
    return view('materiaReg');
  }

  public function avisoMatMSU()
  {
    return view('materiaRegMSU');
  }

  public function avisoMatCPT()
  {
    return view('materiaRegCPT');
  }

  function insert(Request $request)
  {
    if ($request->ajax()) {
      $rules = array(
        'id_materia.*'  => 'required',
        'nombre.*'  => 'required',
        'carrera.*'  => 'required',
        'tipo_periodo.*'  => 'required'
      );
      $error = Validator::make($request->all(), $rules);
      if ($error->fails()) {
        return response()->json([
          'error'  => $error->errors()->all()
        ]);
      }

      $id_materia = $request->id_materia;
      $nombre = $request->nombre;
      $carrera = $request->carrera;
      $tipo_periodo = $request->tipo_periodo;
      for ($count = 0; $count < count($nombre); $count++) {
        $data = array(
          'id_materia' => $id_materia[$count],
          'nombre'  => $nombre[$count],
          'carrera'  => $carrera[$count],
          'tipo_periodo'  => $tipo_periodo[$count]
        );
        $insert_data[] = $data;
      }

      Materia::insert($insert_data);
      return response()->json([
        'success'  => 'Datos añadidos correctamente'
      ]);
    }
  }


  public function ver_selectsVSUP($clave_cct, $rvoe)
  {

    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '1')->orderBy('created_at', 'desc')->get();

    $plan = ModeloPlan::select('plan_estudio.rvoe', 'plan_estudio.nombre_plan')
      ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
      ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
      ->where('institucion.clave_cct', '=', $clave_cct)
      ->get();

    //CCT141220   RVOE1416

    $asignatura = Materia::select('asignatura.clave_asignatura', 'asignatura.nombre_asignatura')
      ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
      ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_asignatura.rvoe')->where('fk_rvoe', '=', $rvoe)
      ->paginate(5);


    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    //return view('InsertarMateriaSUP')->with(compact('escuela','plan','asignatura'));
    return view('InsertarMateriaSUP', compact('escuela', 'asignatura', 'plan'));
  }

  public function xDD($clave_cct)
  {

    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '1')->orderBy('created_at', 'desc')->get();

    $datos = ModeloInstitucion::all();
    $plan = ModeloPlan::select('plan_estudio.rvoe', 'plan_estudio.nombre_plan')
      ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
      ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
      ->where('institucion.clave_cct', '=', $clave_cct)
      ->get();


    return view('InsertarMateriaSUP')->with(compact('plan', 'escuela', 'datos'));
  }

  public function getCCT(Request $clave_cct)
  {
    $nombre_institucion = ModeloInstitucion::find($clave_cct);


    $plan = ModeloPlan::select('plan_estudio.rvoe', 'plan_estudio.nombre_plan')
      ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
      ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
      ->where('institucion.clave_cct', '=', $nombre_institucion)
      ->get();

    return view('InsertarMateriaSUP')->with(compact('plan', 'escuela'));
  }


  public function ver_formularioVSUP()
  {
    return view('InsertarMateriaSUP');
  }

  public function ver_selectsVSUP1(Request $var)
  {


    $escuela = ModeloInstitucion::all()->where('id_tipo_institucion', '1');


    $plan = ModeloPlan::all()->where('id_tipo_nivel', '1');

    //CCT141220   RVOE1416

    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('InsertarMateriaSUP')->with(compact('escuela', 'plan'));
  }

  public function inserMateriaVSUP(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    return redirect()->to('avisoMatVSUP');
    //return ('xD');

  }

  public function ver_selectsVMSU(Request $var)
  {


    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '2')->get();

    $plan = ModeloPlan::select('rvoe')->where('id_tipo_nivel', '2')->orderBy('created_at', 'desc')->get();

    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('insertarMateriaVMSU')->with(compact('escuela', 'plan'));
  }

  public function ver_selectsVCPT(Request $var)
  {


    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '3')->get();;

    $plan = ModeloPlan::select('rvoe')->where('id_tipo_nivel', '3')->orderBy('created_at', 'desc')->get();;

    //return view('InsertarPlanEstudio', compact('escuela','tipo'));
    return view('insertarMateriaVCPT')->with(compact('escuela', 'plan'));
  }


  public function inserMateriaVMSU(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    //return 'xD MSU';
    return redirect()->to('avisoMatVMSU');
    //return redirect('/');

  }


  public function inserMateriaVCPT(Request $var)
  {
    request()->validate([

      'clave_asignatura' => ['required', 'string', 'min:3', 'max:10', 'unique:asignatura'],
      'nombre_asignatura' => ['required', 'string'],
      'no_creditos' => ['required'],
      'seriacion' => ['nullable'],
      'tipo_asignatura' => ['nullable'],
      'no_periodo' => ['nullable'],
      'clave_seriacion' => ['nullable'],
      'no_parciales' => ['nullable'],
      'no_periodo' => ['nullable'],
      'fk_rvoe' => ['required']

    ]);


    $clave_asignatura = $var->input('clave_asignatura');
    $nombre_asignatura = $var->input('nombre_asignatura');
    $no_creditos = $var->input('no_creditos');
    $seriacion = $var->input('seriacion');
    $fk_rvoe = $var->input('fk_rvoe');
    $tipo_asignatura = $var->input('tipo_asignatura');
    $no_periodo = $var->input('no_periodo');
    $clave_seriacion = $var->input('clave_seriacion');
    $no_parciales = $var->input('no_parciales');
    $no_periodo = $var->input('no_periodo');


    Materia::create([
      'clave_asignatura' => $clave_asignatura, 'nombre_asignatura' => $nombre_asignatura, 'no_creditos' => $no_creditos, 'seriacion' => $seriacion, 'fk_rvoe' => $fk_rvoe, 'tipo_asignatura' => $tipo_asignatura, 'no_periodo' => $no_periodo, 'clave_seriacion' => $clave_seriacion, 'no_parciales' => $no_parciales, 'no_periodo' => $no_periodo
    ]);

    ModeloPlanAsig::create(['clave_asignatura' => $clave_asignatura, 'rvoe' => $fk_rvoe]);

    //return 'xD CPT';
    return redirect()->to('avisoMatVCPT');
    //return redirect('/');

  }

  public function ver_formularioVMSU()
  {
    return view('insertarMateriaVMSU');
  }

  public function ver_formularioVCPT()
  {
    return view('insertarMateriaVCPT');
  }


  public function avisoVMat()
  {
    return view('avisoMatVSUP');
  }

  public function avisoVMatMSU()
  {
    return view('avisoMatVMSU');
  }

  public function avisoVMatCPT()
  {
    return view('avisoMatVCPT');
  }

  public function formEditarMat($clave_cct, $rvoe, $clave_asignatura)
  {
    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
      ->where('clave_cct', '=', $clave_cct)
      ->orderBy('created_at', 'desc')->take(1)->get();
    $plan = ModeloPlan::select('rvoe', 'nombre_plan')->where('rvoe', '=', $rvoe)
      ->get();

    $uno['uno'] = Materia::select(
      'clave_asignatura',
      'no_creditos',
      'nombre_asignatura',
      'seriacion',
      'fk_rvoe',
      'no_periodo',
      'no_periodo',
      'tipo_asignatura',
      'clave_seriacion',
      'no_parciales'
    )->where('clave_asignatura', $clave_asignatura)->take(1)->first();
    return view('editMatSup', compact('escuela', 'plan'), $uno);
  }

  public function editar_materia($clave_asignatura, Request $data)
  {

    request()->validate([

      /*'clave_asignatura' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('asignatura')],
            'nombre_asignatura' => ['required','string'],
            'no_creditos' => ['required'],
            'seriacion' => ['nullable'],
            'tipo_asignatura' => ['nullable'],
            'no_periodo' => ['nullable'],
            'clave_seriacion' => ['nullable'],
            'no_parciales' => ['nullable'],
            'no_periodo' => ['nullable'],
            'fk_rvoe' => ['required']*/
      'nombre_asignatura' => ['required', 'string']


    ]);

    Materia::where('clave_asignatura', $clave_asignatura)
      ->update([

        /*'clave_asignatura' => $data->clave_asignatura,
            'nombre_asignatura' => $data->nombre_asignatura,
            'no_creditos' => $data->no_creditos,
            'seriacion' => $data->seriacion,
            'tipo_asignatura' =>$data->tipo_asignatura,
            'no_periodo' => $data->no_periodo,
            'clave_seriacion' => $data->clave_seriacion,
            'no_parciales' => $data->no_parciales,
            'no_periodo' => $data->no_periodo,
            'fk_rvoe' => $data->fk_rvoe*/
        'nombre_asignatura' => $data->nombre_asignatura,

      ]);
    //2008122020/123442|/mat4

    return ('editado correctamente x');
    //return redirect()->to('planes/'.$clave_cct);
  }

  public function formEditarMatMSU($clave_cct, $rvoe, $clave_asignatura)
  {
    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
      ->where('clave_cct', '=', $clave_cct)
      ->orderBy('created_at', 'desc')->take(1)->get();
    $plan = ModeloPlan::select('rvoe', 'nombre_plan')->where('rvoe', '=', $rvoe)
      ->get();

    $uno['uno'] = Materia::select(
      'clave_asignatura',
      'no_creditos',
      'nombre_asignatura',
      'seriacion',
      'fk_rvoe',
      'no_periodo',
      'no_periodo',
      'tipo_asignatura',
      'clave_seriacion',
      'no_parciales'
    )->where('clave_asignatura', $clave_asignatura)->take(1)->first();
    return view('editMatMSU', compact('escuela', 'plan'), $uno);
  }

  public function editar_materiaMSU($rvoe, $clave_asignatura, Request $data)
  {

    request()->validate([

      /*'clave_asignatura' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('asignatura')],
            'nombre_asignatura' => ['required','string'],
            'no_creditos' => ['required'],
            'seriacion' => ['nullable'],
            'tipo_asignatura' => ['nullable'],
            'no_periodo' => ['nullable'],
            'clave_seriacion' => ['nullable'],
            'no_parciales' => ['nullable'],
            'no_periodo' => ['nullable'],
            'fk_rvoe' => ['required']*/
      'nombre_asignatura' => ['required', 'string'],


    ]);

    Materia::where('clave_asignatura', $clave_asignatura)
      ->update([

        /*'clave_asignatura' => $data->clave_asignatura,
            'nombre_asignatura' => $data->nombre_asignatura,
            'no_creditos' => $data->no_creditos,
            'seriacion' => $data->seriacion,
            'tipo_asignatura' =>$data->tipo_asignatura,
            'no_periodo' => $data->no_periodo,
            'clave_seriacion' => $data->clave_seriacion,
            'no_parciales' => $data->no_parciales,
            'no_periodo' => $data->no_periodo,
            'fk_rvoe' => $data->fk_rvoe*/
        'nombre_asignatura' => $data->nombre_asignatura,

      ]);
    //2008122020/123442|/mat4

    return ('editado correctamente');
    //return redirect()->to('planes/'.$clave_cct);
  }

  public function formEditarMatCPT($clave_cct, $rvoe, $clave_asignatura)
  {
    $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
      ->where('clave_cct', '=', $clave_cct)
      ->orderBy('created_at', 'desc')->take(1)->get();
    $plan = ModeloPlan::select('rvoe', 'nombre_plan')->where('rvoe', '=', $rvoe)
      ->get();

    $uno['uno'] = Materia::select(
      'clave_asignatura',
      'no_creditos',
      'nombre_asignatura',
      'seriacion',
      'fk_rvoe',
      'no_periodo',
      'no_periodo',
      'tipo_asignatura',
      'clave_seriacion',
      'no_parciales'
    )->where('clave_asignatura', $clave_asignatura)->take(1)->first();
    return view('editMatCPT', compact('escuela', 'plan'), $uno);
  }

  public function editar_materiaCPT($rvoe, $clave_asignatura, Request $data)
  {

    request()->validate([

      /*'clave_asignatura' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('asignatura')],
            'nombre_asignatura' => ['required','string'],
            'no_creditos' => ['required'],
            'seriacion' => ['nullable'],
            'tipo_asignatura' => ['nullable'],
            'no_periodo' => ['nullable'],
            'clave_seriacion' => ['nullable'],
            'no_parciales' => ['nullable'],
            'no_periodo' => ['nullable'],
            'fk_rvoe' => ['required']*/
      'nombre_asignatura' => ['required', 'string'],


    ]);

    Materia::where('clave_asignatura', $clave_asignatura)
      ->update([

        /*'clave_asignatura' => $data->clave_asignatura,
            'nombre_asignatura' => $data->nombre_asignatura,
            'no_creditos' => $data->no_creditos,
            'seriacion' => $data->seriacion,
            'tipo_asignatura' =>$data->tipo_asignatura,
            'no_periodo' => $data->no_periodo,
            'clave_seriacion' => $data->clave_seriacion,
            'no_parciales' => $data->no_parciales,
            'no_periodo' => $data->no_periodo,
            'fk_rvoe' => $data->fk_rvoe*/
        'nombre_asignatura' => $data->nombre_asignatura,

      ]);
    //2008122020/123442|/mat4

    return ('editado correctamente');
    //return redirect()->to('planes/'.$clave_cct);
  }

  function asignarCalificacionEquivalencias($rvoe, $vigencia, $curp, $clave_grupo)
  {
    $rvoe = decrypt($rvoe);
    $vigencia =  decrypt($vigencia);
    $curp = decrypt($curp);
    $clave_grupo = decrypt($clave_grupo);
    $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
    $no_periodo = $grupo->no_periodo;
    $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
    $alumno = Alumno::join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
      ->join('inscripcion_equivalencia', 'inscripcion_equivalencia.fk_curp', '=', 'alumno_inscripcion.fk_curp_alumno')
      ->where('alumno.curp', '=', $curp)->take(1)->first();
    // return $alumno;
    $asignaturas = ModeloAsignatura::where('fk_rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)
      ->where('no_periodo', '<', $no_periodo)->get();
    return view('califiEquivalencias', compact('grupo', 'clave_grupo', 'plan', 'alumno', 'asignaturas'));
  }

  function agregarCalificacionEqui(Request $request)
  {
    $array = $request->array;
    $rvoe = $request->rvoe;
    $vigencia = $request->vigencia;
    $curp = $request->curp;
    $clave_grupo = $request->clave_grupo;
    $folio_equivalencia = $request->folio_equivalencia;
    for ($i = 0; $i < sizeof($array); $i++) {
      if ($array[$i][4] != null || $array[$i][4] > 5) {
        ModeloDetalleEquiv::create([
          'folio_equivalencia' => $folio_equivalencia,
          'curp' => $curp,
          'fk_clave_asignatura' => $array[$i][1],
          'calificacion' => $array[$i][4],
          'fk_id_status' => 2,
          'rvoe' => $rvoe,
          'vigencia' => $vigencia
        ]);
        ModeloAluGpoAsig::create([
          'curp' => $curp,
          'clave_asignatura' => $array[$i][1],
          'rvoe' => $rvoe,
          'vigencia' => $vigencia,
          'status_aa' => 2,
          'promedio_final' => $array[$i][4]
        ]);
      }
    }
    return response()->json("Exito");
  }
}
