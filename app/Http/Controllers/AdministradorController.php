<?php

namespace App\Http\Controllers;

use App\Institucion;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnvioCorreo;
use App\Mail\Registro;
use App\ModeloAnalistaInstitucion;
use App\Models\Alumno;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloBitacora;
use App\Models\ModeloCicloEscolar;
use App\Models\ModeloInstitucion;
use App\PlanEstudio;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;


class AdministradorController extends Controller
{
    public function listarUsuario(Request $request)
    {
        $nombre = $request->get('nombre_usuario');
        $clave_usuario = $request->get('clave_usuario');
        $datos = User::select(
            'usuarios.id',
            'usuarios.clave_usuario',
            'usuarios.email',
            'usuarios.nombre_usuario',
            'usuarios.apellido_paterno',
            'usuarios.apellido_materno',
            'institucion.nombre_institucion',
            'roles.descripcion'
        )
            ->join('institucion', 'institucion.clave_cct', '=', 'usuarios.institucion')
            ->join('roles', 'roles.id', '=', 'usuarios.role_id')
            ->where("usuarios.autorizado", "=", 0)
            ->name($nombre)
            ->clave($clave_usuario)
            ->paginate(5);

        $nombrec['nombrec'] = null;
        return view('datosUsuarios', compact('datos'), $nombrec);
    }

    public function listaAnalistas(Request $request)
    {
        $nombre = $request->get('nombre_usuario');
        $clave_usuario = $request->get('clave_usuario');
        $datos = User::select(
            'usuarios.id',
            'usuarios.clave_usuario',
            'usuarios.email',
            'usuarios.nombre_usuario',
            'usuarios.apellido_paterno',
            'usuarios.apellido_materno',
            'institucion.nombre_institucion',
            'roles.descripcion'
        )
            ->join('institucion', 'institucion.clave_cct', '=', 'usuarios.institucion')
            ->join('roles', 'roles.id', '=', 'usuarios.role_id')->where("usuarios.autorizado", "=", 1)
            ->where('usuarios.role_id', '=', 2)
            ->name($nombre)
            ->clave($clave_usuario)
            ->paginate(5);

        return view('listaAnalistas', compact('datos'));
    }

    public function lista_users_CtrlEscolar(Request $request)
    {
        $nombre = $request->get('nombre_usuario');
        $clave_usuario = $request->get('clave_usuario');
        $datos = User::select(
            'usuarios.id',
            'usuarios.clave_usuario',
            'usuarios.email',
            'usuarios.nombre_usuario',
            'usuarios.apellido_paterno',
            'usuarios.apellido_materno',
            'institucion.nombre_institucion',
            'roles.descripcion'
        )
            ->join('institucion', 'institucion.clave_cct', '=', 'usuarios.institucion')
            ->join('roles', 'roles.id', '=', 'usuarios.role_id')->where("usuarios.autorizado", "=", 1)
            ->where('usuarios.role_id', '=', 3)
            ->name($nombre)
            ->clave($clave_usuario)
            ->paginate(5);

        return view('listarCtrlEscolar', compact('datos'));
    }

    public function instituciones_de_analista($clave_usuario)
    {

        $datos = ModeloInstitucion::select(
            'institucion.clave_cct',
            'institucion.clave_dgpi',
            'institucion.nombre_institucion',
            'calle',
            'municipio',
            'colonia',
            'codigo_postal',
            'numero_exterior'
        )
            ->join('analista_institucion', 'analista_institucion.clave_cct', '=', 'institucion.clave_cct')
            ->where('analista_institucion.clave_usuario', '=', $clave_usuario)->paginate(5);

        $uno['uno'] = User::select('clave_usuario', 'nombre_usuario', 'apellido_paterno', 'apellido_materno')->where('clave_usuario', '=', $clave_usuario)->take(1)->first();
        if ($datos->count() == 0) {
            return redirect()->back()->with('message2', 'La Opcion seleccionada no contiene datos, elija otra opcion');
        }
        return view('institucionesAsignadas', compact('datos'), $uno);
    }

    public function eliminarInstitucionAsignada(Request $request)
    {
        $clave_usuario = $request->input('clave_usuario');
        $clave_cct = $request->input('clave_cct');
        $analista_institucion = ModeloAnalistaInstitucion::where('clave_usuario', '=', $clave_usuario)
            ->where('clave_cct', '=', $clave_cct);
        $analista_institucion->delete();
        ModeloInstitucion::where('clave_cct', '=', $clave_cct)
            ->update(
                ['asignado' => 0]
            );
        return redirect()->back()->with('message', 'Institucion desvinculada');
    }
    public function listarUsuariosRoles()
    {
        $datos = User::where("autorizado", "=", 1)->paginate(2);
        return view('usuariosRoles', compact('datos', 'nombrec'));
    }

    public function editarRole($clave_usuario, Request $request)
    {
        $role = $request->input('optradio');
        $user = user::whereRaw('clave_usuario = ?', [$clave_usuario])->first();
        $user->role_id = $request->optradio;
        $user->save();
        $datos = User::where("autorizado", "=", 1)->paginate(2);
        return redirect()->route('rolesUsuarios', [$datos]);
    }

    public function activarUsuario($id)
    {
        $user = User::find($id);
        $user->autorizado = 1;
        $user->save();
        Mail::to($user['email'])->send(new Registro(1));
        $nombrec['nombrec'] = 1;
        return redirect('listarUsuario')->with($nombrec);
    }

    public function eliminarAnalista($clave_usuario)
    {
        $user = User::select('id', 'clave_usuario')->whereRaw('clave_usuario = ?', [$clave_usuario])->first();
        $institucion = ModeloAnalistaInstitucion::select('clave_cct')->where('clave_usuario', '=', $clave_usuario)->get();
        $i = 0;
        $arr = count($institucion);
        $arr2 = $institucion;
        for ($i = 0; $i < $arr; $i++) {
            ModeloInstitucion::where('clave_cct', '=', $arr2[$i]['clave_cct'])
                ->update(
                    ['asignado' => 0]
                );
        }

        // ModeloAnalistaInstitucion::where('clave_usuario',$clave_usuario)->delete();
        $user->delete();
        return redirect()->back()->with('message', 'Analista Eliminado');
        //return $arr2;
    }

    public function eliminarUsuario($id)
    {

        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('message', 'Usuario Eliminado');
    }

    public function eliminarCtrl($id)
    {

        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('message', 'Usuario Eliminado');
    }


    public function institucionesJSON()
    {
        $instituciones = ModeloInstitucion::all()->lists('clave_cct');
    }

    public function asignarInstitucion()
    {
        $analistas = User::all()->where('role_id', '=', 2);
        $instituciones = ModeloInstitucion::all()->where('clave_cct', '!=', 'CGEMSySCyT')->where('asignado', '!=', '1');
        //return $instituciones;
        return view('asignarInstituciones', compact('instituciones', 'analistas'));
    }

    public function asignar(Request $request)
    {
        $i = 0;
        $arr = count($request->instituciones);
        $arr2 = $request->instituciones;
        for ($i = 0; $i < $arr; $i++) {
            ModeloInstitucion::where('clave_cct', $arr2[$i])
                ->update(
                    ['asignado' => 1]
                );
        }
        $inst = $request->instituciones;
        for ($count = 0; $count < count($request->instituciones); $count++) {
            $data = array(
                'clave_usuario' => $request->analista,
                'clave_cct'  => $inst[$count],


            );
            $insert_data[] = $data;
        }
        ModeloAnalistaInstitucion::insert($insert_data);

        return redirect()->back()->with('message', 'Insituciones Asignadas');
    }

    public function ins_suOmsu()
    {
        return view('superiorOmedia');
    }
    public function ver_ins_suOmsu()
    {
        return view('verSuMsu');
    }
    public function planes_suOmsu()
    {
        return view('planesSuperiorOMedia');
    }

    public function vistaReportes()
    {
        $institucionSU =  Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 1)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $institucionMSU = Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 2)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $institucionCPT = Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 3)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $ciclo =  ModeloCicloEscolar::all();
        return view('reportesInstituciones', compact('institucionSU', 'institucionMSU', 'institucionCPT', 'ciclo'));
    }

    public function vistaReportesCarrera()
    {
        $institucionSU =  Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 1)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $institucionMSU = Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 2)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $institucionCPT = Institucion::select('clave_cct', 'nombre_institucion')
            ->where('id_tipo_institucion', '=', 3)
            ->where('clave_cct', '!=', 'CGEMSySCyT')->get();
        $ciclo =  ModeloCicloEscolar::all();
        return view('reportesCarreras', compact('institucionSU', 'institucionMSU', 'institucionCPT', 'ciclo'));
    }

    public function consultaAjax(Request $request)
    {
        $clave_cct = $request->clave_cct;
        $carreras =   ModeloActualizarPlan::select(
            'actualizacion_plan.rvoe',
            'actualizacion_plan.nombre_plan',
            'actualizacion_plan.id_duracion',
            'duracion.nombre_duracion',
            'actualizacion_plan.vigencia'
        )
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'actualizacion_plan.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->join('duracion', 'duracion.id_duracion', '=', 'actualizacion_plan.id_duracion')
            ->where('institucion.clave_cct', '=', $clave_cct)->get();

        return response()->json($carreras);
    }

    public function consultaAjax2(Request $request)
    {
        $rvoe = $request->rvoe;
        $vigencia = $request->vigencia;

        $periodo =   ModeloActualizarPlan::select('actualizacion_plan.id_duracion', 'duracion.nombre_duracion', 'actualizacion_plan.vigencia')
            ->join('duracion', 'duracion.id_duracion', '=', 'actualizacion_plan.id_duracion')
            ->where('actualizacion_plan.rvoe', '=', $rvoe)
            ->where('actualizacion_plan.vigencia', '=', $vigencia)
            ->get();

        /*$periodo =   PlanEstudio::select('plan_estudio.id_duracion', 'duracion.nombre_duracion')
            ->join('duracion', 'duracion.id_duracion', '=', 'plan_estudio.id_duracion')
            ->where('plan_estudio.rvoe', '=', $rvoe)->get();*/
        return response()->json($periodo);
    }
    public function consultaAjax3(Request $request)
    {
        $valor = $request->valor;
        if ($valor == '1') {
            $instituciones = ModeloInstitucion::select('clave_cct', 'nombre_institucion')
                ->where('id_tipo_institucion', '=', 1)->where('clave_cct', '!=', 'CGEMSySCyT')
                ->get();
            return response()->json($instituciones);
        } elseif ($valor == '2') {
            $instituciones = ModeloInstitucion::select('clave_cct', 'nombre_institucion')
                ->where('id_tipo_institucion', '=', 2)->where('clave_cct', '!=', 'CGEMSySCyT')
                ->get();
            return response()->json($instituciones);
        }
    }

    public function generarReporte()
    {
        // = DB::table('alumno')->selectRaw('matricula, count(matricula)')->get();
        $matriculaTotal = Alumno::selectRaw('matricula, count(matricula)')
            ->join('alumno_grupo', 'alumno_grupo.curp', '=', 'alumno.curp')
            ->join('grupo', 'grupo.clave_grupo', '=', 'alumno_grupo.clave_grupo')
            ->join('ciclo_escolar', 'ciclo_escolar.id_ciclo_escolar', '=', 'grupo.fk_clave_ciclo_escolar')
            ->join('plan_grupo', 'plan_grupo.clave_grupo', '=', 'grupo.clave_grupo')
            ->join('plan_estudio', 'plan_estudio.rvoe', '=', 'plan_grupo.rvoe')
            ->join('institucion_plan', 'institucion_plan.rvoe', '=', 'plan_estudio.rvoe')
            ->join('institucion', 'institucion.clave_cct', '=', 'institucion_plan.clave_cct')
            ->where('institucion.clave_cct', '=', '2008122020')
            ->where('grupo.fk_clave_ciclo_escolar', '=', '2020-2021')
            ->groupBy('matricula')->get()
            ->count();
        return $matriculaTotal;
    }

    public function formCiclo()
    {
        return view('insertarCicloEscolar');
    }

    public function agregarCiclo(Request $request)
    {
        request()->validate([
            'id_ciclo_escolar' => ['required', 'string', 'min:5', 'unique:ciclo_escolar'],
            'fecha_inicio' => ['required'],
            'fecha_fin' => ['required']
        ]);

        $id = $request->input('id_ciclo_escolar');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $actual = $request->input('actual');
        $contarActuales = ModeloCicloEscolar::selectRaw('id_ciclo_escolar, count(id_ciclo_escolar)')
            ->where('actual', '=', 1)->groupBy('id_ciclo_escolar')->get()
            ->count();

        if ($contarActuales = !0) {
            return redirect()->back()->with('message2', '¡Ya existe un Ciclo Escolar Actual!');
        } else {
            ModeloCicloEscolar::insert([
                'id_ciclo_escolar' => $id,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'actual' => $actual
            ]);

            return redirect()->back()->with('message', 'Ciclo Escolar creado correctamente');
        }
    }

    public function logs()
    {
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d');
        //return $fecha;
        $bitacora = ModeloBitacora::where('fecha', 'LIKE', "%$fecha%")->paginate(5);
        return view('verLogs', compact('bitacora'));
    }
}
