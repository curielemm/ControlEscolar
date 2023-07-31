<?php

namespace App\Http\Controllers;

use App\Institucion;
use App\Models\Alumno;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAsignatura;
use App\Models\ModeloGrupo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\ModeloInstitucion;
use App\Models\ModeloPlan;
use App\Models\ModeloPlanCPT;
use App\Models\ModeloPlanGrupo;
use App\Models\ModeloPlanMSU;
use App\Models\ModeloTipoDirectivo;
use App\PlanEstudio;
use DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AnalistaController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function registrarInstitucion()
    {
        return view('registroInstitucion');
    }

    public function registroIns(Request $request)
    {
        $clave_cct = $request->input('clave_cct');
        $nombre = $request->input('nombre');
        $reglamento = $request->input('reglamento');
        $plan_estudio = $request->input('plan_estudio');
        $no_inscripcion = $request->input('no_inscripcion');
        $fecha_inscripcion = $request->input('fecha_inscripcion');

        ModeloInstitucion::create([
            'clave_cct' => $clave_cct, 'nombre' => $nombre,
            'reglamento' => $reglamento, 'plan_estudio' => $plan_estudio, 'no_inscripcion' => $no_inscripcion, 'fecha_inscripcion' => $fecha_inscripcion
        ]);
        return redirect('/');
    }

    public function misInstituciones(Request $request)
    {
        $nombre = $request->get('institucion');
        $clave_cct = $request->get('clave_cct');
        $clave_usuario = auth()->user()->clave_usuario;
        $datos = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion'

        )
            ->join('analista_institucion', 'analista_institucion.clave_cct', '=', 'institucion.clave_cct')
            ->where('analista_institucion.clave_usuario', '=', $clave_usuario)->name($nombre)
            ->cct($clave_cct)->paginate(5);
        return view('misInstituciones', compact('datos'));
    }

    public function listarInstitucion(Request $request)
    {
        $nombre = $request->get('institucion');
        $clave_cct = $request->get('clave_cct');
        $TotalInstituciones = Institucion::selectRaw('clave_cct, count(clave_cct)')
            ->where('id_tipo_institucion', '=', '1')
            ->where('clave_cct', '!=', 'CGEMSySCyT')
            ->groupBy('clave_cct')->get()
            ->count();
        $institucion = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion',
            'institucion.municipio',
            'institucion.codigo_postal',
            'institucion.colonia',
            'institucion.calle',
            'institucion.numero_interior',
            'institucion.numero_exterior',
            'institucion.pagina_web',
            'institucion.directivo_autorizado',
            'tipo_institucion.nombre_tipo_institucion'
        )->join('tipo_institucion', 'tipo_institucion.id_tipo_institucion', '=', 'institucion.id_tipo_institucion')
            ->where('institucion.clave_cct', '!=', 'CGEMSySCyT')->where('institucion.id_tipo_institucion', '=', 1)
            ->name($nombre)
            ->cct($clave_cct)
            ->paginate(5);
        if ($institucion->count() == 0) {
            return redirect()->back()->with('message2', 'La opcion seleccionada no contiene datos, elija otra opcion');
        }
        return view('datosInstitucion', compact('institucion', 'TotalInstituciones'));
        //return $institucion;
    }

    public function listarInstitucionMSU(Request $request)
    {
        $nombre = $request->get('institucion');
        $clave_cct = $request->get('clave_cct');
        $TotalInstituciones = Institucion::selectRaw('clave_cct, count(clave_cct)')
            ->where('id_tipo_institucion', '=', '2')
            ->where('clave_cct', '!=', 'CGEMSySCyT')
            ->groupBy('clave_cct')->get()
            ->count();

        $institucion = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion',
            'institucion.municipio',
            'institucion.codigo_postal',
            'institucion.colonia',
            'institucion.calle',
            'institucion.numero_interior',
            'institucion.numero_exterior',
            'institucion.pagina_web',
            'institucion.directivo_autorizado',
            'tipo_institucion.nombre_tipo_institucion'
        )->join('tipo_institucion', 'tipo_institucion.id_tipo_institucion', '=', 'institucion.id_tipo_institucion')
            ->where('institucion.clave_cct', '!=', 'CGEMSySCyT')->where('institucion.id_tipo_institucion', '=', 2)
            ->name($nombre)
            ->cct($clave_cct)
            ->get();
        if ($institucion->count() == 0) {
            return redirect()->back()->with('message2', 'La opcion seleccionada no contiene datos, elija otra opcion');
        }
        return view('datosInstitucionMSU', compact('institucion', 'TotalInstituciones'));
        //return $institucion;
    }

    public function listarInstitucionCPT(Request $request)
    {
        $nombre = $request->get('institucion');
        $clave_cct = $request->get('clave_cct');
        $TotalInstituciones = Institucion::selectRaw('clave_cct, count(clave_cct)')
            ->where('id_tipo_institucion', '=', '3')
            ->where('clave_cct', '!=', 'CGEMSySCyT')
            ->groupBy('clave_cct')->get()
            ->count();
        $institucion = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion',
            'institucion.municipio',
            'institucion.codigo_postal',
            'institucion.colonia',
            'institucion.calle',
            'institucion.numero_interior',
            'institucion.numero_exterior',
            'institucion.pagina_web',
            'institucion.directivo_autorizado',
            'tipo_institucion.nombre_tipo_institucion'
        )->join('tipo_institucion', 'tipo_institucion.id_tipo_institucion', '=', 'institucion.id_tipo_institucion')
            ->where('institucion.clave_cct', '!=', 'CGEMSySCyT')->where('institucion.id_tipo_institucion', '=', 3)
            ->name($nombre)
            ->cct($clave_cct)
            ->paginate(5);
        if ($institucion->count() == 0) {
            return redirect()->back()->with('message2', 'La opcion seleccionada no contiene datos, elija otra opcion');
        }
        return view('datosInstitucionesCPT', compact('institucion', 'TotalInstituciones'));
        //return $institucion;
    }

    public function editar_institucion($clave_cct)
    {
        $tipos = ModeloTipoDirectivo::all();
        $tipoIns = DB::table('tipo_institucion')->where('id_tipo_institucion', '1')->get();
        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )
            ->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')->where('clave_cct', '=', $clave_cct)->take(1)->first();
        return view('editarInstitucion', compact('tipos', 'tipoIns'), $uno);
    }

    public function edit_Institucion($clave_cct, Request $data)
    {

        $id = $clave_cct;
        request()->validate([

            'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
            'clave_cct' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('institucion')->ignore($clave_cct, 'clave_cct')],
            'clave_dgpi' => ['required', 'string', 'min:3', 'max:10', ValidationRule::unique('institucion')->ignore($clave_cct, 'clave_cct')],
            'codigo_postal' => ['required', 'integer'],
            'calle' => ['required', 'string', 'max:120'],
            'numero_exterior' => ['required', 'string'],


            'colonia' => ['required', 'string', 'min:1', 'max:120'],
            'municipio' => ['required', 'string', 'min:1', 'max:120'],
            'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:2'],
            'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],


            'id_tipo_institucion' => ['required']


        ]);

        ModeloInstitucion::where('clave_cct', $clave_cct)
            ->update([
                'clave_cct' => $data->clave_cct,
                'clave_dgpi' => $data->clave_dgpi,
                'nombre_institucion' => $data->nombre_institucion,
                'municipio' => $data->municipio,
                'codigo_postal' => $data->codigo_postal,
                'colonia' => $data->colonia,
                'calle' => $data->calle,
                'numero_interior' => $data->numero_interior,
                'numero_exterior' => $data->numero_exterior,
                'id_tipo_directivo' => $data->id_tipo_directivo,
                'directivo_autorizado' => $data->directivo_autorizado,
                'id_tipo_institucion' => $data->id_tipo_institucion,
                'pagina_web' => $data->pagina_web,
            ]);


        return redirect()->to('listarInstitucion');
    }

    public function eliminarInstitucion($clave_cct)
    {
        ModeloInstitucion::where('clave_cct', '=', $clave_cct)->delete();
        return redirect()->back()->with('message', 'Institucion Eliminada');
    }

    public function editar_institucionMSU($clave_cct)
    {
        $tipos = ModeloTipoDirectivo::all();
        $tipoIns = DB::table('tipo_institucion')->where('id_tipo_institucion', '2')->get();
        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )
            ->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')->where('clave_cct', '=', $clave_cct)->take(1)->first();
        return view('editarInstitucionMSU', compact('tipos', 'tipoIns'), $uno);
    }

    public function edit_InstitucionMSU($clave_cct, Request $data)
    {

        $id = $clave_cct;
        request()->validate([

            'nombre_institucion' => ['required', 'string', 'min:5', 'max:150'],
            'clave_cct' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('institucion')->ignore($clave_cct, 'clave_cct')],
            'codigo_postal' => ['required', 'integer'],
            'calle' => ['required', 'string', 'max:120'],
            'numero_exterior' => ['required', 'string'],
            'numero_interior' => ['nullable', 'integer'],

            'colonia' => ['required', 'string', 'min:1', 'max:120'],
            'municipio' => ['required', 'string', 'min:1', 'max:120'],
            'id_tipo_directivo' => ['required', 'integer', 'min:1',  'max:2'],
            'directivo_autorizado' => ['required', 'string', 'min:1', 'max:120'],
            'pagina_web' => ['nullable', 'string', 'min:1', 'max:120'],

            'id_tipo_institucion' => ['required']


        ]);

        ModeloInstitucion::where('clave_cct', $clave_cct)
            ->update([
                'clave_cct' => $data->clave_cct,
                'clave_dgpi' => $data->clave_dgpi,
                'nombre_institucion' => $data->nombre_institucion,
                'municipio' => $data->municipio,
                'codigo_postal' => $data->codigo_postal,
                'colonia' => $data->colonia,
                'calle' => $data->calle,
                'numero_interior' => $data->numero_interior,
                'numero_exterior' => $data->numero_exterior,
                'id_tipo_directivo' => $data->id_tipo_directivo,
                'directivo_autorizado' => $data->directivo_autorizado,
                'periodico_oficial' => $data->periodico_oficial,
                'id_tipo_institucion' => $data->id_tipo_institucion,
                'pagina_web' => $data->pagina_web,
            ]);


        return redirect()->to('listarInstitucion');
    }


    public function dashboardAnalista()
    {
        return view('dashboardAnalista');
    }

    public function listarPlanesAnalista($clave_cct, Request $request)
    {
        $clave_cct = decrypt($clave_cct);
        $clave_usuario = auth()->user()->clave_usuario;
        $datos1 = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion'
        )
            ->join('analista_institucion', 'analista_institucion.clave_cct', '=', 'institucion.clave_cct')
            ->where('analista_institucion.clave_usuario', '=', $clave_usuario)->where('analista_institucion.clave_cct', '=', $clave_cct)->get();
        // return $datos1;
        if (sizeOf($datos1) == 0) {
            return redirect()->back()->with('message2', 'No tienes asignada esta Institución, contacta a un Administrador.');
        }

        $nombre_plan = $request->get('nombre_plan');
        $revoe = $request->get('revoe');
        $id_status = $request->get('id_status');
        $datos = ModeloPlan::select(
            'plan_estudio.clave_plan',
            'plan_estudio.nombre_plan',
            'plan_estudio.rvoe',
            'id_tipo_nivel',
            'plan_estudio.clave_dgp',
            'plan_estudio.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'dof'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('institucion.clave_cct', $clave_cct)
            ->revoe($revoe)
            ->name($nombre_plan)
            ->status($id_status)
            ->paginate(5);
        $nivel = $datos[0]['id_tipo_nivel'];
        $uno['uno'] = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        // return $clave_cct;
        if ($datos->count() == 0) {
            return redirect()->back()->with('message2', 'La Institucion seleccionada no contiene planes, elija otra opcion');
        }

        return view('planesAnalista', compact('datos', 'nivel'), $uno);
    }

    public function perfilPlanesAnalista($rvoe, $clave_cct, $vigencia)
    {
        $rvoe = decrypt($rvoe);
        $clave_cct = decrypt($clave_cct);
        $vigencia = decrypt($vigencia);
        $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        $datos = ModeloActualizarPlan::select(
            'nombre_plan',
            'rvoe',
            'actualizacion_plan.id_turno',
            'turno.nombre_turno',
            'actualizacion_plan.id_tipo_nivel',
            'nivel_educativo.nombre_nivel_educativo',
            'actualizacion_plan.vigencia'
        )
            ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
            ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
        return view('menuPlanesAnalista', compact('datos', 'institucion'));
    }

    public function listarPlanes($clave_cct, Request $request)
    {
        //$clave_cct =$request->get('clave_cct');
        $nombre_plan = $request->get('nombre_plan');
        $revoe = $request->get('revoe');
        $id_status = $request->get('id_status');
        $datos = ModeloPlan::select(
            'plan_estudio.clave_plan',
            'plan_estudio.nombre_plan',
            'plan_estudio.rvoe',
            'plan_estudio.clave_dgp',
            'plan_estudio.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'plan_estudio.id_tipo_nivel',
            'nivel_educativo.nombre_nivel_educativo',
            'dof'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'plan_estudio.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->where('institucion.clave_cct', $clave_cct)
            ->revoe($revoe)
            ->name($nombre_plan)
            ->status($id_status)
            ->paginate(5);
        $nivel = $datos[0]['id_tipo_nivel'];
        $uno['uno'] = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        // return $clave_cct;
        if ($datos->count() == 0) {
            return redirect()->back()->with('message2', 'La Institucion seleccionada no contiene planes, elija otra opcion');
        }

        return view('planes', compact('datos', 'nivel'), $uno);
    }

    public function listarPlanesMSU($clave_cct, Request $request)
    {
        $tipo = $request->get('tipo');
        $revoe = $request->get('revoe');
        $id_status = $request->get('id_status');
        $datos = ModeloPlan::select(
            'plan_estudio_msu.rvoe_msu',
            'plan_estudio_msu.rvoe_msu',
            'plan_estudio_msu.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'nivel_educativo_msu.nombre_nivel_educativo'
        )
            ->join('institucion-plan_msu', 'institucion-plan_msu.rvoe_msu', '=', 'plan_estudio_msu.rvoe_msu')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion-plan_msu.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio_msu.status_institucion')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio_msu.id_modalidad')
            ->join('nivel_educativo_msu', 'nivel_educativo_msu.id_nivel_educativo', '=', 'plan_estudio_msu.id_nivel_educativo_msu')
            ->where('institucion.clave_cct', $clave_cct)
            ->revoe($revoe)
            ->tipo($tipo)
            ->status($id_status)
            ->paginate(5);
        $uno['uno'] = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        return view('planesMSU', compact('datos'), $uno);
    }

    public function listarPlanesCPT($clave_cct, Request $request)
    {
        $tipo = $request->get('tipo');
        $revoe = $request->get('revoe');
        $id_status = $request->get('id_status');
        $datos = ModeloPlanCPT::select(
            'plan_estudio_cpt.revoe_cpt',
            'plan_estudio_cpt.revoe_cpt',
            'plan_estudio_cpt.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'nivel_educativo_msu.nombre_nivel_educativo'
        )
            ->join('institucion-plan_msu', 'institucion-plan_msu.revoe_cpt', '=', 'plan_estudio_cpt.revoe_cpt')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion-plan_msu.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio_cpt.status_institucion')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio_cpt.id_modalidad')
            ->join('nivel_educativo_msu', 'nivel_educativo_msu.id_nivel_educativo', '=', 'plan_estudio_cpt.id_nivel_educativo_msu')
            ->where('institucion.clave_cct', $clave_cct)
            ->revoe($revoe)
            ->tipo($tipo)
            ->status($id_status)
            ->paginate(5);
        $uno['uno'] = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        return view('planesMSU', compact('datos'), $uno);
    }

    public function fichaTecnica($clave_cct)
    {

        $ciclo = '2020-2021';
        $datos = PlanEstudio::select(
            'plan_estudio.clave_plan',
            'plan_estudio.nombre_plan',
            'plan_estudio.rvoe',
            'plan_estudio.clave_dgp',
            'plan_estudio.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'id_tipo_nivel',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'plan_estudio.descripcion'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $matriculaTotal = Alumno::selectRaw('matricula, count(matricula)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('matricula')->get()
            ->count();
        $matriculaHombres = Alumno::selectRaw('matricula, count(matricula)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'H')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('matricula')->get()
            ->count();

        $matriculaMujeres = Alumno::selectRaw('matricula, count(matricula)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'M')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('matricula')->get()
            ->count();

        $datos = PlanEstudio::select('plan_estudio.rvoe', 'nombre_plan', 'plan_estudio.rvoe', 'vigencia', 'descripcion')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')

            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')
            ->where('clave_cct', $clave_cct)->take(1)->first();
        return view('fichaTec', compact('datos', 'matriculaTotal', 'matriculaHombres', 'matriculaMujeres'), $uno);
    }

    public function pdf(Request $request)
    {

        $clave_cct = $request->input('clave_cct');
        $ciclo = $request->input('id_ciclo_escolar');
        $nivel = $request->input('nivel');
        $datos = PlanEstudio::select(
            'plan_estudio.clave_plan',
            'plan_estudio.nombre_plan',
            'plan_estudio.rvoe',
            'plan_estudio.clave_dgp',
            'plan_estudio.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'id_tipo_nivel',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'plan_estudio.descripcion'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $matriculaTotal = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();
        $matriculaHombres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'H')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();

        $matriculaMujeres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'M')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();

        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')
            ->where('clave_cct', $clave_cct)->take(1)->first();

        if ($nivel == 1) {
            $pdf = PDF::loadView('fichaTec', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        } elseif ($nivel == 2) {
            $pdf = PDF::loadView('fichaTecMSU', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        } elseif ($nivel == 3) {
            $pdf = PDF::loadView('fichaTecCPT', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        }


        return $pdf->stream('archivo.pdf');
    }

    public function pdfMSU(Request $request)
    {

        $clave_cct = $request->input('clave_cct');
        $ciclo = $request->input('id_ciclo_escolar');
        $datos = PlanEstudio::select('plan_estudio.clave_plan', 'plan_estudio.nombre_plan', 'plan_estudio.rvoe', 'plan_estudio.clave_dgp', 'plan_estudio.vigencia', 'modalidad.nombre_modalidad', 'status.nombre_status')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $matriculaTotal = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();
        $matriculaHombres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'H')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();

        $matriculaMujeres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->where('alumno.sexo', '=', 'M')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();

        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')
            ->where('clave_cct', $clave_cct)->take(1)->first();

        $pdf = PDF::loadView('fichaTec', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
            ->setPaper('a4', 'landscape');
        return $pdf->stream('archivo.pdf');
    }

    public function pdfCarreraSU(Request $request)
    {
        $clave_cct = $request->input('clave_cct');
        $ciclo = $request->input('id_ciclo_escolar');
        $rvoe = $request->input('rvoe');
        $nivel = $request->input('nivel');

        $plan = PlanEstudio::select(
            'plan_estudio.clave_plan',
            'plan_estudio.nombre_plan',
            'plan_estudio.rvoe',
            'plan_estudio.clave_dgp',
            'plan_estudio.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'id_tipo_nivel',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'plan_estudio.descripcion'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('plan_estudio.rvoe', $rvoe)->take(1)->first();
        // return $plan;
        $matriculaTotal = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->where('plan_estudio.rvoe', '=', $rvoe)
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();
        $matriculaHombres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->where('plan_estudio.rvoe', '=', $rvoe)
            ->where('alumno.sexo', '=', 'H')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();

        $matriculaMujeres = Alumno::selectRaw('alumno.curp, count(alumno.curp)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->where('plan_estudio.rvoe', '=', $rvoe)
            ->where('alumno.sexo', '=', 'M')
            ->where('grupo.fk_clave_ciclo_escolar', '=', $ciclo)
            ->groupBy('alumno.curp')->get()
            ->count();
        $uno['uno'] = ModeloInstitucion::select(
            'clave_cct',
            'clave_dgpi',
            'nombre_institucion',
            'municipio',
            'codigo_postal',
            'colonia',
            'calle',
            'numero_interior',
            'numero_exterior',
            'pagina_web',
            'periodico_oficial',
            'directivo_autorizado',
            'tipo_directivo.nombre_tipo_directivo',
            'tipo_directivo.id_tipo_directivo'
        )->join('tipo_directivo', 'tipo_directivo.id_tipo_directivo', '=', 'institucion.id_tipo_directivo')
            ->where('clave_cct', $clave_cct)->take(1)->first();
        $data = "https://quickchart.io/chart?c={type:'bar',data:{labels:['Total','Hombres','Mujeres'],datasets:[{label:'Alumnos',data:[" . $matriculaTotal . "," . $matriculaHombres . "," . $matriculaMujeres . "]}]}}";
        //return $data;
        /*    if ($nivel == 1) {
            $pdf = PDF::loadView('fichaTec', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        } elseif ($nivel == 2) {
            $pdf = PDF::loadView('fichaTecMSU', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        } elseif ($nivel == 3) {
            $pdf = PDF::loadView('fichaTecCPT', compact('datos', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres'), $uno)
                ->setPaper('a4', 'landscape');
        }*/
        $pdf = PDF::loadView('fichaTecCarreraSU', compact('plan', 'matriculaTotal', 'matriculaMujeres', 'matriculaHombres', 'ciclo', 'data'), $uno)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('archivo.pdf');
    }

    public function listaAsignaturas($clave_plan)
    {
        $datos = ModeloAsignatura::select(
            'asignatura.clave_asignatura',
            'asignatura.nombre_asignatura',
            'asignatura.no_creditos',
            'asignatura.seriazion',
            'asignatura.tipo_asignatura',
            'asignatura.semestre_cuatrimestre'
        )
            ->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
            ->join('plan_estudio', 'plan_estudio.clave_plan', '=', 'plan_asignatura.clave_plan')
            ->where('plan_estudio.clave_plan', $clave_plan)
            ->paginate(5);
        $uno['uno'] = ModeloPlan::where('clave_plan', $clave_plan)->take(1)->first();
        return view('listaAsignaturas', compact('datos'), $uno);
    }

    public function busquedaInstitucion(Request $request)
    {
    }

    public function kardex()
    {
    }

    public function perfil()
    {
        return view('perfilSU');
    }

    public function acuseValidacionInscripcion($clave_grupo, $rvoe, $clave_cct, $vigencia)
    {
        //set_time_limit(300);
        $archivoValidacionInscripcion = ModeloPlanGrupo::where('rvoe', '=', $rvoe)
            ->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
            ->take(1)->first();
        if ($archivoValidacionInscripcion->archivo_validacion_inscripcion == null) {
            $nombre_usuario = auth()->user()->nombre_usuario;
            $apellido_paterno = auth()->user()->apellido_paterno;
            $apellido_materno = auth()->user()->apellido_materno;
            date_default_timezone_set('America/Mexico_City');
            $DateAndTime = date('d-m-Y h:i:s a', time());
            /*Si en el servidor principal no funciona, editar esta linea desde format hasta merge
            y modificar en la vista acusevalidacion inscripcion
            con lo siguiente data:image/svg+xml;base64*/
            $codigoQR = QrCode::format('png')->mergeString(Storage::get("public/cg2.png"), .9, true)->errorCorrection('H')->generate('Validado por: ' . $nombre_usuario . ' ' . $apellido_paterno . ' Fecha: ' . $DateAndTime);
            //return base64_decode($codigoQR);
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
                ->where('grupo.clave_grupo', $clave_grupo)->take(1)->first();

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
                'alumno_inscripcion.observaciones'
            )
                ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
                ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
                ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
                ->where('grupo.clave_grupo', '=', $clave_grupo) //->where('alumno_inscripcion.status_inscripcion', '!=', '1')
                //->where('alumno_inscripcion.status_inscripcion', '=', '0')
                ->get();
            if ($alumnos[0] == null) {
                return  redirect()->back()->with('message2', 'No hay alumnos en este grupo');
            }

            // return $institucion;
            $nivel = $plan->id_nivel_educativo;
            // return $nivel;
            //return view('acuseValidacionInscripcion', compact('institucion', 'plan', 'grupo', 'alumnos', 'nivel', 'codigoQR'));
            $pdf = PDF::loadView('acuseValidacionInscripcion', compact('institucion', 'plan', 'grupo', 'alumnos', 'nivel', 'codigoQR'))
                ->setPaper('a4', 'landscape');
            //  $archivo_inscripcion = $pdf->stream('archivo.pdf');
            $file = $pdf->output();
            $nombreArchivo = $clave_grupo . $rvoe . $vigencia . '.pdf';
            $filearchivo =  Storage::put('public/' . $nombreArchivo, $file);
            ModeloPlanGrupo::where('rvoe', '=', $rvoe)
                ->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
                ->update(['archivo_validacion_inscripcion' => $nombreArchivo]);
            return Storage::response("public/$nombreArchivo");
        } else {
            return Storage::response("public/$archivoValidacionInscripcion->archivo_validacion_inscripcion");
        }
    }
    public function detallePlan($rvoe, $clave_cct)
    {
        $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        $plan = ModeloPlan::where('rvoe', $rvoe)->take(1)->first();
        $datos = ModeloActualizarPlan::select(
            'actualizacion_plan.clave_plan',
            'actualizacion_plan.nombre_plan',
            'actualizacion_plan.rvoe',
            'id_tipo_nivel',
            'actualizacion_plan.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'actualizacion_plan.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'archivo'
        )
            ->join('status', 'status.id_status', '=', 'actualizacion_plan.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'actualizacion_plan.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
            ->where('rvoe', $rvoe)
            ->paginate(5);

        $nivel = $plan->id_tipo_nivel;

        return view('planesEspecificados', compact('institucion', 'plan', 'datos', 'nivel'));
    }
    public function detallePlanAnalista($rvoe, $clave_cct)
    {
        $rvoe = decrypt($rvoe);
        $clave_cct = decrypt($clave_cct);
        $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        $plan = ModeloPlan::where('rvoe', $rvoe)->take(1)->first();
        $datos = ModeloActualizarPlan::select(
            'actualizacion_plan.clave_plan',
            'actualizacion_plan.nombre_plan',
            'actualizacion_plan.rvoe',
            'id_tipo_nivel',
            'actualizacion_plan.vigencia',
            'modalidad.nombre_modalidad',
            'status.nombre_status',
            'actualizacion_plan.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'archivo'
        )
            ->join('status', 'status.id_status', '=', 'actualizacion_plan.id_status')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'actualizacion_plan.id_modalidad')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
            ->where('rvoe', $rvoe)
            ->paginate(5);
        $nivel = $plan->id_tipo_nivel;

        return view('detallePlanAnalista', compact('institucion', 'plan', 'datos', 'nivel'));
    }

    public function acuseValidacionInscripcionEquivalencias($clave_grupo, $rvoe, $clave_cct, $vigencia)
    {
        //set_time_limit(300);
        $clave_cctE = encrypt($clave_cct);
        $rvoeE = encrypt($rvoe);
        $vigenciaE = encrypt($vigencia);
        $clave_grupoE = encrypt($clave_grupo);
        $archivoValidacionInscripcion = ModeloPlanGrupo::where('rvoe', '=', $rvoe)
            ->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
            ->take(1)->first();
        if ($archivoValidacionInscripcion->archivo_validacion_equivalencia == null) {
            $nombre_usuario = auth()->user()->nombre_usuario;
            $apellido_paterno = auth()->user()->apellido_paterno;
            $apellido_materno = auth()->user()->apellido_materno;
            date_default_timezone_set('America/Mexico_City');
            $DateAndTime = date('d-m-Y h:i:s a', time());
            /*Si en el servidor principal no funciona, editar esta linea desde format hasta merge
            y modificar en la vista acusevalidacion inscripcion
            con lo siguiente data:image/svg+xml;base64*/
            $codigoQR = QrCode::format('png')->generate('Validado por: ' . $nombre_usuario . ' ' . $apellido_paterno . ' Fecha: ' . $DateAndTime . ' http://127.0.0.1:8000/' . $clave_cct . '/' . $rvoe . '/' . $vigencia . '/' . $clave_grupo);
            //return base64_decode($codigoQR);
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
                ->where('grupo.clave_grupo', $clave_grupo)->take(1)->first();

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
                'alumno_inscripcion.observaciones',
                'inscripcion_equivalencia.certificado_parcial',
                'inscripcion_equivalencia.equivalencia',
                'inscripcion_equivalencia.folio_equivalencia'
            )
                ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
                ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
                ->join('alumno_inscripcion', 'alumno_inscripcion.fk_curp_alumno', '=', 'alumno.curp')
                ->join('inscripcion_equivalencia', 'inscripcion_equivalencia.fk_curp', '=', 'alumno_inscripcion.fk_curp_alumno')
                ->where('grupo.clave_grupo', '=', $clave_grupo) //->where('alumno_inscripcion.status_inscripcion', '!=', '1')
                //->where('alumno_inscripcion.status_inscripcion', '=', '0')
                ->get();
            if ($alumnos[0] == null) {
                return  redirect()->back()->with('message2', 'No hay alumnos en este grupo');
            }
            $nivel = $plan->id_nivel_educativo;
            $pdf = PDF::loadView('acuseValidacionInscripcionEqui', compact('institucion', 'plan', 'grupo', 'alumnos', 'nivel', 'codigoQR'))
                ->setPaper('a4', 'landscape');
            $file = $pdf->output();
            $nombreArchivo = $clave_grupo . $rvoe . $vigencia . '.pdf';
            $filearchivo =  Storage::put('public/' . $nombreArchivo, $file);
            ModeloPlanGrupo::where('rvoe', '=', $rvoe)
                ->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
                ->update(['archivo_validacion_equivalencia' => $nombreArchivo]);
            return Storage::response("public/$nombreArchivo");
        } else {
            return Storage::response("public/$archivoValidacionInscripcion->archivo_validacion_inscripcion");
        }
    }
}
