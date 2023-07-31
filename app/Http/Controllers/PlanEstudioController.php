<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanEstudio;
use App\Institucion;

use App\Models\ModeloPlan;
use App\Models\ModeloPlanMSU;
use App\Models\ModeloPlanCPT;
use App\Models\ModeloInstitucion;
use App\Models\ModeloInactivo;
use App\Models\Materia;
use App\Models\ModeloActualizacionPlan;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloCicloEscolar;
use App\Models\ModeloInsPlan;
use App\Models\ModeloInsPlanMSU;
use App\Models\ModeloInsPlanCPT;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
//use DB;
use Illuminate\Validation\ValidationRuleParser;

class PlanEstudioController extends Controller
{
    public function registroPlanEstudio()
    {
        return view('registroPlanEstudio');
    }

    public function insertPlanEstudio(Request $var)
    {
        $clave_plan = $var->input('clave_plan');
        $revoe = $var->input('revoe');
        $nombre_plan = $var->input('nombre_plan');
        $vigencia = $var->input('vigencia');
        $no_creditos = $var->input('no_creditos');
        $duracion_ciclo = $var->input('duracion_ciclo');
        $descripcion = $var->input('descripcion');
        PlanEstudio::create([
            'clave_plan' => $clave_plan, 'revoe' => $revoe, 'nombre_plan' => $nombre_plan, 'vigencia' => $vigencia,
            'no_creditos' => $no_creditos, 'duracion_ciclo' => $duracion_ciclo, 'descripcion' => $descripcion
        ]);

        return redirect()->to('/');
    }

    public function listarPlanes()
    {
        //lista de planes por institucion
        $clave_cct = auth()->user()->institucion;
        $datos = PlanEstudio::select(
            'plan_estudio.rvoe',
            'fecha_rvoe',
            'fecha_pub_periodico',
            'clave_plan',
            'nombre_plan',
            'vigencia',
            'descripcion',
            'id_tipo_nivel',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'dof'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $uno['uno'] = Institucion::where('clave_cct', $clave_cct)->take(1)->first();
        // $datos = PlanEstudio::paginate(5);
        //  return $datos;
        /*if ($datos->count() == 0){
            $datos['id_tipo_nivel']=1;
        }*/
        $nivel = $datos[0]['id_tipo_nivel'];

        return view('listaPlanes', compact('datos', 'nivel'), $uno);
        //return $planes;
    }

    public function detallePlanControl($rvoe)
    {
        $clave_cct = auth()->user()->institucion;
        $institucion = ModeloInstitucion::where('clave_cct', $clave_cct)->take(1)->first();
        $plan = ModeloPlan::join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion_plan.rvoe', $rvoe)
            ->where('institucion.clave_cct', '=', $clave_cct)
            ->take(1)->first();
        if ($plan == null) {
            return redirect()->back()->with('message2', 'Plan de estudios no correspondiente a tu Institucion');
        }
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

        return view('detallePlanControl', compact('institucion', 'plan', 'datos', 'nivel'));
    }

    public function planesPorInsitucion()
    {
        //lista de planes por institucion
        $clave_cct = auth()->user()->institucion;
        $datos = PlanEstudio::select(
            'plan_estudio.rvoe',
            'clave_plan',
            'nombre_plan',
            'vigencia',
            'descripcion',
            'plan_estudio.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->where('institucion.clave_cct', $clave_cct)
            ->paginate(5);
        $uno['uno'] = Institucion::where('clave_cct', $clave_cct)->take(1)->first();
        // $datos = PlanEstudio::paginate(5);
        //  return $datos;
        /*if ($datos->count() == 0){
            $datos['id_tipo_nivel']=1;
        }*/
        $nivel = $datos[0]['id_tipo_nivel'];
        return $datos;
        return view('listadePlanesGrupos', compact('datos', 'nivel'), $uno);
        //return $planes;
    }

    public function eliminar_plan_estudios()
    {
        $datos = DB::table('turno')

            ->get();
        return view('datitos', compact('datos'));
    }

    public function formEditarPlan($clave_cct, $rvoe)
    {
        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
            ->where('clave_cct', '=', $clave_cct)
            ->orderBy('created_at', 'desc')->take(1)->get();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '1')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '<=', '6')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();
        $uno['uno'] = ModeloPlan::select(
            'clave_plan',
            'clave_dgp',
            'rvoe',
            'fecha_rvoe',
            'fecha_pub_periodico',
            'nombre_plan',
            'tipo_nivel.id_tipo_nivel',
            'tipo_nivel.nombre_tipo_nivel',
            'nivel_educativo.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'modalidad.id_modalidad',
            'modalidad.nombre_modalidad',
            'opcion_educativa.id_opcion_educativa',
            'opcion_educativa.nombre_opcion_educativa',
            'duracion.id_duracion',
            'duracion.nombre_duracion',
            'turno.id_turno',
            'turno.nombre_turno',
            'status.id_status',
            'status.nombre_status',
            'opcion_educativa.nombre_opcion_educativa',
            'plan_estudio.descripcion',
            'vigencia',
            'calif_min',
            'calif_maxima',
            'calif_aprobatoria',
            'intentos',
            'dof'
        )
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'plan_estudio.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('opcion_educativa', 'opcion_educativa.id_opcion_educativa', '=', 'plan_estudio.id_opcion_educativa')
            ->join('duracion', 'duracion.id_duracion', '=', 'plan_estudio.id_duracion')
            ->join('turno', 'turno.id_turno', '=', 'plan_estudio.id_turno')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->where('rvoe', $rvoe)->take(1)->first();
        if ($uno['uno']['intentos'] == 0) {
            return redirect()->back()->with('message2', 'No tienes intentos para editar este plan');
        }
        return view('formEditarPlan', compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'), $uno);
    }
    public function editar_plan_estudios($rvoe, $clave_cct, Request $data)
    {

        request()->validate([

            //'clave_plan' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('plan_estudio')->ignore($data->clave_plan, 'clave_plan')],
            'clave_dgp' => ['required', 'string', 'min:3', 'max:10', ValidationRule::unique('plan_estudio')->ignore($data->clave_dgp, 'clave_dgp')],
            'rvoe' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('plan_estudio')->ignore($rvoe, 'rvoe')],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'nombre_plan' => ['required', 'string', 'min:1', 'max:120'],
            /* 'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:8'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:8'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:8'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:8'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:8'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:8'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
            'calif_min' => ['required'],
            'calif_maxima' => ['required'],
            'calif_aprobatoria' => ['required'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],*/

        ]);
        $dof = $data->dof;
        $dofAnterior = $data->dofAnterior;

        if ($dof != null) {
            if ($dofAnterior != null) {
                Storage::delete($dofAnterior);
            }
            $dof = $data->file('dof')->store('public/');
        }

        ModeloPlan::where('rvoe', $rvoe)
            ->update([
                // 'clave_plan' => $data->clave_plan,
                'clave_dgp' => $data->clave_dgp,
                'rvoe' => $data->rvoe,
                'fecha_rvoe' => $data->fecha_rvoe,
                /*'id_tipo_nivel' => $data->id_tipo_nivel,
                'id_nivel_educativo' => $data->id_nivel_educativo,
                'id_modalidad' => $data->id_modalidad,
                'id_opcion_educativa' => $data->id_opcion_educativa,
                'id_duracion' => $data->id_duracion,
                'id_turno' => $data->id_turno,
                'id_status' => $data->id_status,*/
                'fecha_pub_periodico' => $data->fecha_pub_periodico,
                'nombre_plan' => $data->nombre_plan,
                //'vigencia' => $data->vigencia,
                /*'descripcion' => $data->descripcion,
                'calif_min' => $data->calif_min,
                'calif_maxima' => $data->calif_maxima,
                'calif_aprobatoria' => $data->calif_aprobatoria,
                'id_status' => $data->id_status*/
                'intentos' => 0,
                'dof' => $dof

            ]);
        //return ('editado correctamente');
        return redirect()->to('planes/' . $clave_cct)->with('message', 'Plan editado correctamente');
    }

    public function formEditPlanActu($clave_cct, $rvoe, $vigencia)
    {
        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
            ->where('clave_cct', '=', $clave_cct)
            ->orderBy('created_at', 'desc')->take(1)->get();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '1')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '<=', '6')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();
        $ciclos = ModeloCicloEscolar::all();
        $uno['uno'] = ModeloActualizarPlan::select(
            'clave_plan',
            'clave_dgp',
            'rvoe',
            'nombre_plan',
            'tipo_nivel.id_tipo_nivel',
            'tipo_nivel.nombre_tipo_nivel',
            'nivel_educativo.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'modalidad.id_modalidad',
            'modalidad.nombre_modalidad',
            'opcion_educativa.id_opcion_educativa',
            'opcion_educativa.nombre_opcion_educativa',
            'duracion.id_duracion',
            'duracion.nombre_duracion',
            'turno.id_turno',
            'turno.nombre_turno',
            'status.id_status',
            'status.nombre_status',
            'opcion_educativa.nombre_opcion_educativa',
            'actualizacion_plan.descripcion',
            'vigencia',
            'calif_min',
            'calif_maxima',
            'calif_aprobatoria',
            'intentos',
            'archivo'
        )
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'actualizacion_plan.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'actualizacion_plan.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'actualizacion_plan.id_modalidad')
            ->join('opcion_educativa', 'opcion_educativa.id_opcion_educativa', '=', 'actualizacion_plan.id_opcion_educativa')
            ->join('duracion', 'duracion.id_duracion', '=', 'actualizacion_plan.id_duracion')
            ->join('turno', 'turno.id_turno', '=', 'actualizacion_plan.id_turno')
            ->join('status', 'status.id_status', '=', 'actualizacion_plan.id_status')
            ->where('rvoe', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
        if ($uno['uno']['intentos'] == 0) {
            return redirect()->back()->with('message2', 'No tienes intentos para editar este plan');
        }
        return view('formEditPlanActu', compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status', 'ciclos'), $uno);
    }

    public function editar_plan_estudiosAct($rvoe, $clave_cct, $vigencia, Request $data)
    {

        request()->validate([

            'clave_plan' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('plan_estudio')->ignore($data->clave_plan, 'clave_plan')],
            // 'rvoe' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('plan_estudio')->ignore($rvoe, 'rvoe')],
            // 'nombre_plan' => ['required', 'string', 'min:1', 'max:120'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:8'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:8'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:8'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:8'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:8'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:8'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
            'calif_min' => ['required'],
            'calif_maxima' => ['required'],
            'calif_aprobatoria' => ['required'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],

        ]);
        $archivo = $data->archivo;
        $anterior = $data->anterior;
        if ($archivo != null) {
            if ($anterior != null) {
                Storage::delete($anterior);
            }
            $archivo = $data->file('archivo')->store('public/');
        }

        ModeloActualizarPlan::where('rvoe', $rvoe)->where('vigencia', '=', $vigencia)
            ->update([
                'clave_plan' => $data->clave_plan,
                // 'rvoe' => $data->rvoe,
                'id_tipo_nivel' => $data->id_tipo_nivel,
                'id_nivel_educativo' => $data->id_nivel_educativo,
                'id_modalidad' => $data->id_modalidad,
                'id_opcion_educativa' => $data->id_opcion_educativa,
                'id_duracion' => $data->id_duracion,
                'id_turno' => $data->id_turno,
                'id_status' => $data->id_status,
                //'nombre_plan' => $data->nombre_plan,
                'vigencia' => $data->vigencia,
                'descripcion' => $data->descripcion,
                'calif_min' => $data->calif_min,
                'calif_maxima' => $data->calif_maxima,
                'calif_aprobatoria' => $data->calif_aprobatoria,
                'id_status' => $data->id_status,
                'intentos' => 0,
                'archivo' => $archivo

            ]);
        //return ('editado correctamente');
        return redirect()->route('detallePlan', ['rvoe' => $rvoe, 'clave_cct' => $clave_cct])->with('message', 'Plan editado correctamente');
    }

    public function eliminarPlan($clave_plan)
    {
        ModeloPlan::where('clave_plan', '=', $clave_plan)->delete();
        return redirect()->back()->with('message', 'Plan de Estudios Eliminado');
    }


    public function ver_PlanDinamico()
    {
        return view('PlanDinamico');
    }


    function insert(Request $request)
    {
        $clavecita = $request->input('clave_cct');
        $clavezota = $request->input('id_modalidad');

        if ($request->ajax()) {
            $rules = array(
                'clave_plan.*'  => 'required',
                'clave_dgp.*'  => 'required',
                'revoe.*'  => 'required',
                'nombre_plan.*'  => 'required',
                'vigencia.*'  => 'required',
                'no_creditos.*'  => 'required',
                'duracion_ciclo.*'  => 'required',
                'descripcion.*'  => '',
                'id_status.*'  => 'required'
            );

            $error = Validator::make($request->all(), $rules);
            if ($error->fails()) {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $clave_plan = $request->clave_plan;
            $clave_dgp = $request->clave_dgp;
            $revoe = $request->revoe;
            $nombre_plan = $request->nombre_plan;
            $vigencia = $request->vigencia;
            $no_creditos = $request->no_creditos;
            $duracion_ciclo = $request->duracion_ciclo;
            $descripcion = $request->descripcion;
            $id_status = $request->id_status;


            for ($count = 0; $count < count($clave_plan); $count++) {
                $data = array(
                    'clave_plan' => $clave_plan[$count],
                    'clave_dgp' => $clave_dgp[$count],
                    'revoe'  => $revoe[$count],
                    'nombre_plan'  => $nombre_plan[$count],
                    'vigencia'  => $vigencia[$count],
                    'no_creditos'  => $no_creditos[$count],
                    'duracion_ciclo'  => $duracion_ciclo[$count],
                    'descripcion' => $descripcion[$count],
                    'id_status' => $id_status[$count]


                );
                $insert_data[] = $data;
            }
            /*copie lo que haces arriba, es lo mismo, solo que la clave cct lo obtengo del request, 
             el problema era que pasabas un array dentro de otro, por eso al momento de insertar, no sabia que columna era ***cambios*/

            for ($count2 = 0; $count2 < count($clave_plan); $count2++) {
                $data2 = array('clave_cct' =>  $clavecita[0], 'clave_plan' => $clave_plan[$count2]);
                $insert_data2[] = $data2;
            }

            for ($count3 = 0; $count3 < count($clave_plan); $count3++) {
                $data3 = array('clave_plan' => $clave_plan[$count3], 'id_modalidad' =>  $clavezota[0]);
                $insert_data3[] = $data3;
            }

            ModeloPlan::insert($insert_data);
            ModeloInsPlan::insert($insert_data2);
            ModeloPlanMod::insert($insert_data3);
            return response()->json([
                'success'  => $request->id_status
            ]);
        }
    }



    function ver_instituciones(Request $var)
    {
        //$consulta =   ModeloCarrera::get(['nombre']);
        //return $consulta;
        $status['status'] = ModeloStatus::all();

        $modal = ModeloModalidad::all();


        $escuela = ModeloInstitucion::all()->where('clave_cct', '!=', 'CGEMSySCyT');

        $escuelas['escuelas'] = ModeloInstitucion::select('nombre_institucion')->where('clave_cct', '!=', 'CGEMSySCyT')->orderBy('clave_cct', 'desc')->take(1)->get();

        return view('PlanDinamico', compact('escuela', 'modal'), $status);
    }


    function ver_ultima(Request $var)

    {

        $escuelas = ModeloInstitucion::select('nombre_institucion')->where('clave_cct', '!=', 'CGEMSySCyT')->orderBy('clave_cct', 'desc')->take(1)->get();
        return view('PlanDinamico', compact('escuelas'));
    }


    function ver_status(Request $var)
    {
        $status = ModeloStatus::all();
        return view('PlanDinamico', compact('status'));
    }


    ///nuevaas 
    public function ver_insertPlan()
    {
        return view('InsertarPlanEstudio');
    }

    public function ver_insertPlanes()
    {
        return view('insertarPlanesVarios');
    }


    public function ver_planesmsu()
    {
        return view('InsertarPlanMSU');
    }

    public function ver_insertPlanesMSU()
    {
        return view('insertarPlanesVariosMSU');
    }

    public function ver_planesCPT()
    {
        return view('InsertarPlanCPT');
    }

    public function ver_planesVCPT()
    {
        return view('insertarPlanesVariosCPT');
    }

    public function ver_selects(Request $var)
    {

        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '1')->orderBy('created_at', 'desc')->take(1)->get();

        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '1')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '<=', '6')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();

        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('InsertarPlanEstudio')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'));
    }


    public function ver_selectsMSU(Request $var)
    {

        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '2')->orderBy('created_at', 'desc')->take(1)->get();

        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '2')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '7')->orwhere('id_nivel_educativo', '9')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();



        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('InsertarPlanMSU')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'));
    }

    public function ver_selectsCPT(Request $var)
    {

        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')->where('id_tipo_institucion', '3')->orderBy('created_at', 'desc')->take(1)->get();

        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '3')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '8')->orwhere('id_nivel_educativo', '10')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();



        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('InsertarPlanCPT')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'));
    }


    public function insertPlan(Request $var)

    {

        request()->validate([

            'clave_plan' => ['required', 'string', 'min:6', 'max:15', 'unique:plan_estudio'],
            'clave_dgp' => ['required', 'string', 'min:5', 'max:10'],
            'rvoe' => ['required', 'string', 'min:6', 'max:15', 'unique:plan_estudio'],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'nombre_plan' => ['required', 'string', 'min:1', 'max:50'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:6'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:6'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:9'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:6'],
            'descripcion' => ['nullable'],
            'calif_maxima' => ['required'],
            'calif_min' => ['required'],
            'calif_aprobatoria' => ['required']


        ]);

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct');

        $clave_plan = $var->input('clave_plan');
        $clave_dgp = $var->input('clave_dgp');
        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $nombre_plan = $var->input('nombre_plan');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');
        $descripcion = $var->input('descripcion');
        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');


        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);
        ModeloPlan::create([
            'clave_plan' => $clave_plan, 'clave_dgp' => $clave_dgp, 'rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe, 'fecha_pub_periodico' => $fecha_pub_periodico, 'nombre_plan' => $nombre_plan, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status, 'descripcion' => $descripcion,
            'calif_min' => $calif_min, 'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima
        ]);

        ModeloActualizarPlan::create([
            'clave_plan' => $clave_plan,
            'rvoe' => $rvoe
        ]);


        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlan');
        //return redirect('/');
    }


    public function insertPlanMSU(Request $var)

    {

        request()->validate([

            'rvoe' => ['required', 'string', 'min:4', 'max:15', 'unique:plan_estudio'],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:3'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:6'],
            'calif_maxima' => ['required'],
            'calif_min' => ['required'],
            'calif_aprobatoria' => ['required']
        ]);

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct');

        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');
        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');

        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);

        ModeloPlan::create([
            'rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe, 'fecha_pub_periodico' => $fecha_pub_periodico, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status,
            'calif_min' => $calif_min, 'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima
        ]);


        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlanMSU');
        //return redirect('/');
    }


    public function insertPlanCPT(Request $var)

    {

        request()->validate([

            'rvoe' => ['required', 'string', 'min:3', 'max:15', 'unique:plan_estudio'],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:3'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:6'],
            'calif_maxima' => ['required'],
            'calif_min' => ['required'],
            'calif_aprobatoria' => ['required']


        ]);

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct');

        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');

        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');

        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);
        ModeloPlan::create(['rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe, 'fecha_pub_periodico' => $fecha_pub_periodico, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status, 'calif_min' => $calif_min, 'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima]);


        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlanCPT');
        //return ('registrado');
    }

    public function avisoPlan()
    {
        return view('avisoplan');
    }


    public function avisoPlanMSU()
    {
        return view('avisoPlanMSU');
    }

    public function avisoPlanesMSU()
    {
        return view('avisoPlanesMSU');
    }

    public function avisoPlanesVarios()
    {
        return view('avisoPlanesVarios');
    }

    public function avisoPlanCPT()
    {
        return view('avisoPCPT');
    }
    public function avisoPlanVCPT()
    {
        return view('avisoPVcpt');
    }



    public function planesVarios(Request $var)
    {
        $escuela = ModeloInstitucion::all()->where('id_tipo_institucion', '1');
        $ciclos = ModeloCicloEscolar::all();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', "1")->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '<=', '6')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();



        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('insertarPlanesVarios')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status', 'ciclos'));
    }

    public function planesVariosMSU(Request $var)
    {
        $escuela = ModeloInstitucion::all()->where('id_tipo_institucion', '2');

        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', "2")->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '7')->orwhere('id_nivel_educativo', '9')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();



        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('insertarPlanesVariosMSU')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'));
    }

    public function planesVariosCPT(Request $var)
    {
        $escuela = ModeloInstitucion::all()->where('id_tipo_institucion', '3');

        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', "3")->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '8')->orwhere('id_nivel_educativo', '10')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();



        //return view('InsertarPlanEstudio', compact('escuela','tipo'));
        return view('insertarPlanesVariosCPT')->with(compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'));
    }

    public function insertarPVMSU(Request $var)
    {
        request()->validate([

            'rvoe' => ['required', 'string', 'min:3', 'max:15', 'unique:plan_estudio'],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:3'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:6'],
            'calif_maxima' => ['required'],
            'calif_min' => ['required'],
            'calif_aprobatoria' => ['required']

        ]);

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct');

        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');
        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');

        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);
        ModeloPlan::create(['rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe, 'fecha_pub_periodico' => $fecha_pub_periodico, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status, 'calif_min' => $calif_min, 'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima]);

        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlanesMSU');
    }

    public function insertarPV(Request $var)
    {
        request()->validate(
            [

                'clave_plan' => ['required', 'string', 'min:6', 'max:15'],/*aun no es seguro de que clave de plan se utilice 'unique:plan_estudio'*/
                'clave_dgp' => ['required', 'string', 'min:5', 'max:10'],
                'rvoe' => ['required', 'string', 'min:6', 'max:15', 'unique:plan_estudio'],
                'fecha_rvoe' => ['required'],
                'fecha_pub_periodico' => ['required'],
                'nombre_plan' => ['required', 'string', 'min:1', 'max:50'],
                'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:6'],
                'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:6'],
                'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
                'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:9'],
                'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
                'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
                'vigencia' => ['required', 'string'],
                'id_status' => ['required', 'integer', 'min:1', 'max:6'],
                'descripcion' => ['nullable'],
                'archivo' => ['max:3000', 'mimes:pdf'],
                'dof' => ['max:3000', 'mimes:pdf'],
                'calif_maxima' => ['required'],
                'calif_min' => ['required'],
                'calif_aprobatoria' => ['required']
            ]
        );

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct2');

        $clave_plan = $var->input('clave_plan');
        $clave_dgp = $var->input('clave_dgp');
        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $nombre_plan = $var->input('nombre_plan');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');
        $descripcion = $var->input('descripcion');
        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');
        if ($var->file('archivo') != null) {
            $archivo = $var->file('archivo')->store('public/');
        } else {
            $archivo = $var->file('archivo');
        }
        if ($var->file('dof') != null) {
            $dof = $var->file('dof')->store('public/');
        } else {
            $dof = $var->file('dof');
        }
        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);
        ModeloPlan::create([
            'clave_plan' => $clave_plan,
            'clave_dgp' => $clave_dgp, 'rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe,
            'fecha_pub_periodico' => $fecha_pub_periodico,
            'nombre_plan' => $nombre_plan, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status, 'descripcion' => $descripcion,  'calif_min' => $calif_min,
            'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima,
            'intentos' => 1,
            'dof' => $dof
        ]);

        ModeloActualizarPlan::create([
            'clave_plan' => $clave_plan,
            'rvoe' => $rvoe,
            'nombre_plan' => $nombre_plan,
            'id_tipo_nivel' => $id_tipo_nivel,
            'id_nivel_educativo' => $id_nivel_educativo,
            'id_modalidad' => $id_modalidad,
            'id_opcion_educativa' => $id_opcion_educativa,
            'id_duracion' => $id_duracion,
            'id_turno' => $id_turno,
            'vigencia' => $vigencia,
            'id_status' => $id_status,
            'descripcion' => $descripcion,
            'calif_min' => $calif_min,
            'calif_aprobatoria' => $calif_aprobatoria,
            'calif_maxima' => $calif_maxima,
            'intentos' => 1,
            'archivo' => $archivo
        ]);
        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlanesVarios');
    }

    public function insertPlanVCPT(Request $var)

    {

        request()->validate([

            'rvoe' => ['required', 'string', 'min:3', 'max:15', 'unique:plan_estudio'],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:3'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:6'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:6'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:6'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:6'],
            'calif_maxima' => ['required'],
            'calif_min' => ['required'],
            'calif_aprobatoria' => ['required']


        ]);

        $nombre_institucion = $var->input('nombre_institucion');
        $clave_cct = $var->input('clave_cct');

        $rvoe = $var->input('rvoe');
        $fecha_rvoe = $var->input('fecha_rvoe');
        $fecha_pub_periodico = $var->input('fecha_pub_periodico');
        $id_tipo_nivel = $var->input('id_tipo_nivel');
        $id_nivel_educativo = $var->input('id_nivel_educativo');
        $id_modalidad = $var->input('id_modalidad');
        $id_opcion_educativa = $var->input('id_opcion_educativa');
        $id_duracion = $var->input('id_duracion');
        $id_turno = $var->input('id_turno');
        $vigencia = $var->input('vigencia');
        $id_status = $var->input('id_status');
        $calif_min = $var->input('calif_min');
        $calif_maxima = $var->input('calif_maxima');
        $calif_aprobatoria = $var->input('calif_aprobatoria');

        $clave_usuario = auth()->user()->clave_usuario;
        $correo_usuario = auth()->user()->email;
        $statement = "SET @clave_usuario =" . "'" . $clave_usuario . "'";
        $statement2 = "SET @correo_usuario =" . "'" . $correo_usuario . "'";
        DB::statement($statement);
        DB::statement($statement2);
        ModeloPlan::create(['rvoe' => $rvoe, 'fecha_rvoe' => $fecha_rvoe, 'fecha_pub_periodico' => $fecha_pub_periodico, 'id_tipo_nivel' => $id_tipo_nivel, 'id_nivel_educativo' => $id_nivel_educativo, 'id_modalidad' => $id_modalidad, 'id_opcion_educativa' => $id_opcion_educativa, 'id_duracion' => $id_duracion, 'id_turno' => $id_turno, 'vigencia' => $vigencia, 'id_status' => $id_status, 'calif_min' => $calif_min, 'calif_aprobatoria' => $calif_aprobatoria, 'calif_maxima' => $calif_maxima]);

        ModeloInsPlan::create(['rvoe' => $rvoe, 'clave_cct' => $clave_cct]);

        return redirect()->to('avisoPlanesCPT');
        //return ('registrado');
    }





    public function formEditarPlanMSU($clave_cct, $rvoe)
    {
        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
            ->where('clave_cct', '=', $clave_cct)
            ->orderBy('created_at', 'desc')->take(1)->get();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '2')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '7')->orwhere('id_nivel_educativo', '9')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();
        $uno['uno'] = ModeloPlan::select(

            'rvoe',
            'fecha_rvoe',
            'fecha_pub_periodico',
            'tipo_nivel.id_tipo_nivel',
            'tipo_nivel.nombre_tipo_nivel',
            'nivel_educativo.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'modalidad.id_modalidad',
            'modalidad.nombre_modalidad',
            'opcion_educativa.id_opcion_educativa',
            'opcion_educativa.nombre_opcion_educativa',
            'duracion.id_duracion',
            'duracion.nombre_duracion',
            'turno.id_turno',
            'turno.nombre_turno',
            'status.id_status',
            'status.nombre_status',
            'opcion_educativa.nombre_opcion_educativa',
            'vigencia',
            'calif_min',
            'calif_maxima',
            'calif_aprobatoria'
        )
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'plan_estudio.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('opcion_educativa', 'opcion_educativa.id_opcion_educativa', '=', 'plan_estudio.id_opcion_educativa')
            ->join('duracion', 'duracion.id_duracion', '=', 'plan_estudio.id_duracion')
            ->join('turno', 'turno.id_turno', '=', 'plan_estudio.id_turno')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->where('rvoe', $rvoe)->take(1)->first();
        return view('formEditarPlanMSU', compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status'), $uno);
    }

    public function formEditarPlanCPT($clave_cct, $rvoe)
    {
        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
            ->where('clave_cct', '=', $clave_cct)
            ->orderBy('created_at', 'desc')->take(1)->get();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '3')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '8')->orwhere('id_nivel_educativo', '10')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();
        $ciclos = ModeloCicloEscolar::all();
        $uno['uno'] = ModeloPlan::select(
            'rvoe',
            'fecha_rvoe',
            'fecha_pub_periodico',
            'tipo_nivel.id_tipo_nivel',
            'tipo_nivel.nombre_tipo_nivel',
            'nivel_educativo.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'modalidad.id_modalidad',
            'modalidad.nombre_modalidad',
            'opcion_educativa.id_opcion_educativa',
            'opcion_educativa.nombre_opcion_educativa',
            'duracion.id_duracion',
            'duracion.nombre_duracion',
            'turno.id_turno',
            'turno.nombre_turno',
            'status.id_status',
            'status.nombre_status',
            'opcion_educativa.nombre_opcion_educativa',
            'vigencia',
            'calif_min',
            'calif_maxima',
            'calif_aprobatoria'
        )
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'plan_estudio.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('opcion_educativa', 'opcion_educativa.id_opcion_educativa', '=', 'plan_estudio.id_opcion_educativa')
            ->join('duracion', 'duracion.id_duracion', '=', 'plan_estudio.id_duracion')
            ->join('turno', 'turno.id_turno', '=', 'plan_estudio.id_turno')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->where('rvoe', $rvoe)->take(1)->first();
        return view('formEditarPlanCPT', compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status', 'ciclos'), $uno);
    }


    public function editar_plan_estudiosMSU($rvoe, $clave_cct, Request $data)
    {

        request()->validate([

            /*'rvoe' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('plan_estudio')],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:8'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:8'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:8'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:8'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
             'calif_min' => ['required'],
              'calif_maxima' => ['required'],
               'calif_aprobatoria' => ['required']*/
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],


        ]);

        ModeloPlan::where('rvoe', $rvoe)
            ->update([

                /*'rvoe' => $data->rvoe,
                'fecha_rvoe' => $data->fecha_rvoe,
                'id_tipo_nivel' => $data->id_tipo_nivel,
                'id_nivel_educativo' => $data->id_nivel_educativo,
                'id_modalidad' => $data->id_modalidad,
                'id_opcion_educativa' => $data->id_opcion_educativa,
                'id_duracion' => $data->id_duracion,
                'id_turno' => $data->id_turno,
                'id_status' => $data->id_status,
                'fecha_pub_periodico' => $data->fecha_pub_periodico,
                'vigencia' => $data->vigencia,
                'calif_min' => $data->calif_min,
                'calif_maxima' => $data->calif_maxima,
                'calif_aprobatoria' => $data->calif_aprobatoria*/
                'id_status' => $data->id_status,

            ]);

        //return ('editado correctamente MSU');
        return redirect()->to('planes/' . $clave_cct);
    }

    public function editar_plan_estudiosCPT($rvoe, $clave_cct, Request $data)
    {

        request()->validate([


            /*'rvoe' => ['required', 'string', 'min:3', 'max:15', ValidationRule::unique('plan_estudio')],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:8'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:10'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:8'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:10'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:8'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:8'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
             'calif_min' => ['required'],
              'calif_maxima' => ['required'],
               'calif_aprobatoria' => ['required']*/
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],


        ]);

        ModeloPlan::where('rvoe', $rvoe)
            ->update([
                /*'rvoe' => $data->rvoe,
                'fecha_rvoe' => $data->fecha_rvoe,
                'id_tipo_nivel' => $data->id_tipo_nivel,
                'id_nivel_educativo' => $data->id_nivel_educativo,
                'id_modalidad' => $data->id_modalidad,
                'id_opcion_educativa' => $data->id_opcion_educativa,
                'id_duracion' => $data->id_duracion,
                'id_turno' => $data->id_turno,
                'id_status' => $data->id_status,
                'fecha_pub_periodico' => $data->fecha_pub_periodico,
                'vigencia' => $data->vigencia,
                'calif_min' => $data->calif_min,
                'calif_maxima' => $data->calif_maxima,
                'calif_aprobatoria' => $data->calif_aprobatoria*/
                'id_status' => $data->id_status,

            ]);

        //return ('editado correctamente CPT');
        return redirect()->to('planes/' . $clave_cct);
    }

    public function formActualizarPlanSU($clave_cct, $rvoe)
    {
        $escuela = ModeloInstitucion::select('nombre_institucion', 'clave_cct')
            ->where('clave_cct', '=', $clave_cct)
            ->orderBy('created_at', 'desc')->take(1)->get();
        $tipo = DB::table('tipo_nivel')->where('id_tipo_nivel', '1')->get();
        $nivel = DB::table('nivel_educativo')->where('id_nivel_educativo', '<=', '6')->get();
        $modal = DB::table('modalidad')->get();
        $oferta = DB::table('opcion_educativa')->get();
        $duracion = DB::table('duracion')->get();
        $turno = DB::table('turno')->get();
        $status = DB::table('status')->select('id_status', 'nombre_status')->get();
        $ciclos = ModeloCicloEscolar::all();
        $uno['uno'] = ModeloPlan::select(
            'clave_plan',
            'clave_dgp',
            'rvoe',
            'fecha_rvoe',
            'fecha_pub_periodico',
            'nombre_plan',
            'tipo_nivel.id_tipo_nivel',
            'tipo_nivel.nombre_tipo_nivel',
            'nivel_educativo.id_nivel_educativo',
            'nivel_educativo.nombre_nivel_educativo',
            'modalidad.id_modalidad',
            'modalidad.nombre_modalidad',
            'opcion_educativa.id_opcion_educativa',
            'opcion_educativa.nombre_opcion_educativa',
            'duracion.id_duracion',
            'duracion.nombre_duracion',
            'turno.id_turno',
            'turno.nombre_turno',
            'status.id_status',
            'status.nombre_status',
            'opcion_educativa.nombre_opcion_educativa',
            'plan_estudio.descripcion',
            'vigencia',
            'calif_min',
            'calif_maxima',
            'calif_aprobatoria',
            'intentos'
        )
            ->join('tipo_nivel', 'tipo_nivel.id_tipo_nivel', '=', 'plan_estudio.id_tipo_nivel')
            ->join('nivel_educativo', 'nivel_educativo.id_nivel_educativo', '=', 'plan_estudio.id_nivel_educativo')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'plan_estudio.id_modalidad')
            ->join('opcion_educativa', 'opcion_educativa.id_opcion_educativa', '=', 'plan_estudio.id_opcion_educativa')
            ->join('duracion', 'duracion.id_duracion', '=', 'plan_estudio.id_duracion')
            ->join('turno', 'turno.id_turno', '=', 'plan_estudio.id_turno')
            ->join('status', 'status.id_status', '=', 'plan_estudio.id_status')
            ->where('rvoe', $rvoe)->take(1)->first();
        return view('actualizacionPlanSU', compact('escuela', 'tipo', 'nivel', 'modal', 'oferta', 'duracion', 'turno', 'status', 'ciclos'), $uno);
    }

    public function actualizarPlanSU($rvoe, $clave_cct, Request $data)
    {
        request()->validate([

            'clave_plan' => ['required', 'string', 'min:5', 'max:15', ValidationRule::unique('plan_estudio')->ignore($data->clave_plan, 'clave_plan')],
            'clave_dgp' => ['required', 'string', 'min:3', 'max:10', ValidationRule::unique('plan_estudio')->ignore($data->clave_dgp, 'clave_dgp')],
            'fecha_rvoe' => ['required'],
            'fecha_pub_periodico' => ['required'],
            'id_tipo_nivel' => ['required', 'integer', 'min:1', 'max:8'],
            'id_nivel_educativo' => ['required', 'integer', 'min:1', 'max:8'],
            'id_modalidad' => ['required', 'integer', 'min:1', 'max:8'],
            'id_opcion_educativa' => ['required', 'integer', 'min:1', 'max:8'],
            'id_duracion' => ['required', 'integer', 'min:1', 'max:8'],
            'id_turno' => ['required', 'integer', 'min:1', 'max:8'],
            'vigencia' => ['required', 'string'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
            'calif_min' => ['required'],
            'calif_maxima' => ['required'],
            'calif_aprobatoria' => ['required'],
            'id_status' => ['required', 'integer', 'min:1', 'max:8'],
        ]);
        $archivo = $data->file('archivo')->store('public/');
        ModeloActualizarPlan::insert([
            'rvoe' => $rvoe,
            'nombre_plan' => $data->nombre_plan,
            'clave_plan' => $data->clave_plan,
            'id_tipo_nivel' => $data->id_tipo_nivel,
            'id_nivel_educativo' => $data->id_nivel_educativo,
            'id_modalidad' => $data->id_modalidad,
            'id_opcion_educativa' => $data->id_opcion_educativa,
            'id_duracion' => $data->id_duracion,
            'id_turno' => $data->id_turno,
            'id_status' => $data->id_status,
            'vigencia' => $data->vigencia,
            'descripcion' => $data->descripcion,
            'calif_min' => $data->calif_min,
            'calif_maxima' => $data->calif_maxima,
            'calif_aprobatoria' => $data->calif_aprobatoria,
            'id_status' => $data->id_status,
            'intentos' => 1,
            'archivo' => $archivo

        ]);
        return redirect()->route('formAgregarCSV', ['rvoe' => $rvoe, 'clave_cct' => $clave_cct, 'vigencia' => $data->vigencia]);
        return redirect()->route('formActualizarAsignaturas', ['rvoe' => $rvoe, 'clave_cct' => $clave_cct, 'vigencia' => $data->vigencia]);
        //return ('editado correctamente');
        return redirect()->to('planes/' . $clave_cct);
    }
}
