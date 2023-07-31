<?php

namespace App\Http\Controllers;

use App\Institucion;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAsignatura;
use App\Models\ModeloPlan;
use Illuminate\Http\Request;

class CtrlEscolarController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function dashboardCtrlEscolar()
    {
        $clave_institucion = auth()->user()->institucion;
        $uno['uno'] = Institucion::where('clave_cct', $clave_institucion)->take(1)->first();
        return view('dashboardCtrlEscolar', $uno);
    }

    public function kardexEsc()
    {
    }

    public function perfilPlanes($rvoe, $vigencia)
    {
        $rvoe = decrypt($rvoe);
        $vigencia = decrypt($vigencia);
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
            return redirect()->back()->with('message2', 'Este Plan de Estudios aún no contiene asignaturas, Intente mas tarde.');
        }
        return view('menuPlanes', compact('datos'));
    }
}
