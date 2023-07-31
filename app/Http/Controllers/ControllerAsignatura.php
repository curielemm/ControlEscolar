<?php

namespace App\Http\Controllers; //se declara el controlador
use App\Institucion;
use App\Models\ModeloAsignatura;
use App\Models\ModeloPlan;
use App\Models\ModeloPlanAsig;
use App\Models\ModeloCicloEscolar;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Models\ModeloActualizarPlan;
use App\Models\ModeloAluGpoAsig;
use App\Models\ModeloAsignaturaSeriacion;
use App\Models\ModeloCalificacionesExtra;
use App\Models\ModeloInstitucion;
use Dompdf\JavascriptEmbedder;
use Illuminate\Support\Facades\DB;
use Validator;

class ControllerAsignatura extends Controller
{


   public function ver_AsigDinamico()
   {
      return view('AsignaturaDinamico');
   }

   function insert(Request $request)
   {
      if ($request->ajax()) {
         $rules = array(
            'clave_asignatura.*'  => 'required',
            'nombre_asignatura.*'  => 'required',
            'no_creditos.*'  => 'required',
            'seriacion.*'  => '',
            'tipo_asignatura.*'  => '',
            'clave_plan.*'  => 'required',
            'semestre_cuatrimestre.*'  => 'required'
         );

         $error = Validator::make($request->all(), $rules);
         if ($error->fails()) {
            return response()->json([
               'error'  => $error->errors()->all()
            ]);
         }

         $clave_asignatura = $request->clave_asignatura;
         $nombre_asignatura = $request->nombre_asignatura;
         $no_creditos = $request->no_creditos;
         $seriacion = $request->seriacion;
         $tipo_asignatura = $request->tipo_asignatura;
         $clave_plan = $request->clave_plan;
         $semestre_cuatrimestre = $request->semestre_cuatrimestre;


         for ($count = 0; $count < count($clave_asignatura); $count++) {
            $data = array(
               'clave_asignatura' => $clave_asignatura[$count],
               'nombre_asignatura'  => $nombre_asignatura[$count],
               'no_creditos'  => $no_creditos[$count],
               'seriacion'  => $seriacion[$count],
               'tipo_asignatura'  => $tipo_asignatura[$count],
               'clave_plan'  => $clave_plan[$count],
               'semestre_cuatrimestre' => $semestre_cuatrimestre[$count]

            );
            $insert_data[] = $data;
         }


         for ($count2 = 0; $count2 < count($clave_asignatura); $count2++) {
            $data2 = array(
               'clave_asignatura' => $clave_asignatura[$count2],
               'clave_plan' =>  $clave_plan[$count2]
            );

            $insert_data2[] = $data2;
         }

         ModeloAsignatura::insert($insert_data);
         ModeloPlanAsig::insert($insert_data2);

         return response()->json([
            'success'  => 'Datos añadidos correctamente'
         ]);
      }
   }


   function ver_plan(Request $var)
   {
      //$consulta =   ModeloCarrera::get(['nombre']);
      //return $consulta;
      $plan = ModeloPlan::all();
      return view('AsignaturaDinamico', compact('plan'));
   }

   function menuAgregarMaterias()
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
      return view('menuAgregarMaterias', compact('institucionSU', 'institucionMSU', 'institucionCPT'));
   }

   function  vistaAgregarMateriaCSV()
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
      return view('agregarMateriaCSV', compact('institucionSU', 'institucionMSU', 'institucionCPT'));
   }

   function validarCabeceras($array)
   {
      if (sizeof($array) == 7) {
         if ($array[0] == 'clave_asignatura' && $array[1] == 'nombre_asignatura' && $array[2] == 'no_creditos' && $array[3] == 'seriacion' && $array[4] == 'tipo_asignatura' && $array[5] == 'no_parciales' && $array[6] == 'no_periodo') {
            return true;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }

   function validarCabeceras2($array)
   {
      if (sizeof($array) == 2) {
         if ($array[0] == 'clave_asignatura' && $array[1] == 'clave_seriacion') {
            return true;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }



   function agregarMateriasCSV(Request $request)
   {
      request()->validate([
         'file' => ['mimes:csv,txt'],
      ]);

      $file = $request->file('file');
      $rvoe = $request->input('fk_rvoe');
      $tipo_periodo = $request->input('tipo_periodo');
      $vigencia = $request->input('vigencia');
      $lines = file($file);
      $utf8_lines = array_map('utf8_encode', $lines);
      $array = array_map('str_getcsv', $utf8_lines);

      if (sizeof($array) == 0 or null) {
         return redirect()->back()->with('message2', 'El archivo esta vacio');
      }
      if ($this->validarCabeceras($array[0]) != true) {
         return redirect()->back()->with('message2', 'Los nombres de las columnas no corresponden a las indicadas');
      }
      if (sizeof($array) <= 1) {
         return redirect()->back()->with('message2', 'No hay elementos en las columnas');
      }
      $totalAsignaturas = ModeloAsignatura::selectRaw('clave_asignatura,count(clave_asignatura)')
         ->where('fk_rvoe', '=', $rvoe)
         ->where('vigencia', '=', $vigencia)
         ->groupBy('clave_asignatura')->get()
         ->count();
      if ($totalAsignaturas >= 1) {
         return redirect()->back()->with('message2', 'Ya hay asignaturas cargadas en este Plan de estudios');
      }

      for ($i = 1; $i < sizeof($array); ++$i) {
         $data = [
            'clave_asignatura' => $array[$i][0],
            'nombre_asignatura'  =>  $array[$i][1],
            'no_creditos'  =>  $array[$i][2],
            'seriacion'  =>  $array[$i][3],
            'tipo_asignatura'  =>   $array[$i][4],
            'no_parciales'  =>   $array[$i][5],
            'no_periodo' => $array[$i][6],
            'tipo_periodo' => $tipo_periodo,
            'fk_rvoe' => $rvoe,
            'vigencia' => $vigencia
         ];

         $insert_data[] = $data;
      }
      ModeloAsignatura::insert($insert_data);

      for ($i = 1; $i < sizeof($array); ++$i) {
         $data = [
            'rvoe' => $rvoe,
            'clave_asignatura' => $array[$i][0],
            'fecha_actualizacion' => $vigencia
         ];

         $insert_data2[] = $data;
      }

      ModeloPlanAsig::insert($insert_data2);
      return redirect()->route('asignaturasSeriadas', ['rvoe' => $rvoe, 'vigencia' => $vigencia]);
      return redirect()->back()->with('message', 'Datos agregados correctamente');
   }

   function materiasSeriadas($rvoe, $vigencia)
   {
      $asignaturas = ModeloAsignatura::selectRaw(
         'asignatura.clave_asignatura,
         asignatura.nombre_asignatura,
         asignatura.no_periodo,
         (select count(*) from asignatura_seriacion where clave_asignatura = asignatura.clave_asignatura and vigencia = "' . $vigencia . '" ) as seriacion'
      )
         /*$asignaturas = ModeloAsignatura::select(
         'asignatura.clave_asignatura',
         'asignatura.nombre_asignatura',
         'asignatura.no_periodo'
      )*/
         //->join('plan_asignatura', 'plan_asignatura.clave_asignatura', '=', 'asignatura.clave_asignatura')
         ->where('asignatura.fk_rvoe', '=', $rvoe)
         ->where('asignatura.vigencia', '=', $vigencia)
         ->where('asignatura.seriacion', '=', '1')->paginate(5);
      $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', $vigencia)->take(1)->first();
      //return $asignaturas;
      // return $asignaturas;
      return view('asignaturasSeriadas', compact('asignaturas', 'plan'));
   }

   function agregarclavesSeriacion(Request $request)
   {
      //  $clave_cct = $request->input('');
      $rvoe = $request->input('rvoe');
      $vigencia = $request->input('vigencia');
      $clave_asignatura = $request->input('clave_asignatura');
      $clavesSeriacion = $request->campo;
      for ($count = 0; $count < count($clavesSeriacion); $count++) {
         $data = array(
            'clave_asignatura' => $clave_asignatura,
            'clave_seriacion' => $clavesSeriacion[$count],
            'vigencia' => $vigencia
         );
         $insert_data[] = $data;
      }

      ModeloAsignaturaSeriacion::insert($insert_data);
      return redirect()->route('asignaturasSeriadas', ['rvoe' => $rvoe, 'vigencia' => $vigencia])->with('message', 'Clave de Seriacion agregada correctamente');
      // return $insert_data;
   }

   function formActualizarAsignaturas($rvoe, $clave_cct, $vigencia)
   {
      $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
      $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
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
         ->where('plan_asignatura.rvoe', '=', $rvoe)
         ->orderBy('asignatura.no_periodo', 'ASC')->paginate(5);
      //return $materias;
      return view('actualizacionAsignaturas', compact('plan', 'institucion', 'materias'));
   }

   function formAgregarAsigCSV($rvoe, $clave_cct, $vigencia)
   {
      $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)
         ->where('vigencia', '=', $vigencia)->take(1)->first();
      $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
      return view('agregarAsignaturasCSV', compact('plan', 'institucion', 'vigencia'));
   }

   function agregarSeriadasCSV(Request $request)
   {
      request()->validate([
         'file' => ['mimes:csv,txt'],
      ]);

      $file = $request->file('file');
      $rvoe = $request->input('fk_rvoe');
      $vigencia = $request->input('vigencia');
      $lines = file($file);
      $utf8_lines = array_map('utf8_encode', $lines);
      $array = array_map('str_getcsv', $utf8_lines);

      if (sizeof($array) == 0 or null) {
         return redirect()->back()->with('message2', 'El archivo esta vacio');
      }
      if ($this->validarCabeceras2($array[0]) != true) {
         return redirect()->back()->with('message2', 'Los nombres de las columnas no corresponden a las indicadas');
      }
      if (sizeof($array) <= 1) {
         return redirect()->back()->with('message2', 'No hay elementos en las columnas');
      }

      for ($i = 1; $i < sizeof($array); ++$i) {
         $data = [
            'clave_asignatura' => $array[$i][0],
            'clave_seriacion'  =>  $array[$i][1],
            'rvoe' => $rvoe,
            'vigencia' => $vigencia
         ];

         $insert_data[] = $data;
      }
      ModeloAsignaturaSeriacion::insert($insert_data);
      return redirect()->route('panel');
     
   }

   function formAgregarSeriadasCSV($rvoe, $vigencia)
   {
      $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)
         ->where('vigencia', '=', $vigencia)->take(1)->first();
      return view('agregarSeriadasCSV', compact('plan'));
   }

   function calificar(Request $request)
   {
      $clave_grupo = $request->clave_grupo;
      $rvoe = $request->rvoe;
      $vigencia = $request->vigencia;
      $curp = $request->curp;
      $array = $request->array;
      $array2 = $request->array2;
      $tamaño = sizeof($array);
      $parciales = $request->parciales;
      $calificiacion = ModeloActualizarPlan::select('calif_maxima', 'calif_aprobatoria')
         ->where('rvoe', '=', $rvoe)
         ->where('vigencia', '=', $vigencia)
         ->take(1)
         ->first();
      $status = 0;
      // $prueba = 
      for ($i = 0; $i < $tamaño; $i++) {

         if ($parciales == 4) {
            if ($array[$i][8] >= $calificiacion->calif_aprobatoria && $array[$i][8] <= $calificiacion->calif_maxima) {
               $status = 2;
            } else {
               $status = 3;
            }
            ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][0])
               ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
               ->update([
                  'pl1' => $array[$i][2],
                  'pl2' => $array[$i][3],
                  'pl3' => $array[$i][4],
                  'pl4' => $array[$i][5],
                  'ordinario' => $array[$i][6],
                  'final' => $array[$i][7],
                  'promedio_final' => $array[$i][8],
                  'status_aa' => $status,
                  'porcentaje_asistencia' => $array[$i][9],
                  'fpl1' => $array2[0][0],
                  'fpl2' => $array2[0][1],
                  'fpl3' => $array2[0][2],
                  'fpl4' => $array2[0][3],
                  'fordinario' => $array2[0][4],
                  'rfc_docente' => $array[$i][10],
                  'observaciones' => $array[$i][11]
               ]);
         } else if ($parciales == 1) {
            if ($array[$i][5] >= $calificiacion->calif_aprobatoria && $array[$i][5] <= $calificiacion->calif_maxima) {
               $status = 2;
            } else {
               $status = 3;
            }
            ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][0])
               ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
               ->update([
                  'pl1' => $array[$i][2],
                  'ordinario' => $array[$i][3],
                  'final' => $array[$i][4],
                  'promedio_final' => $array[$i][5],
                  'status_aa' => $status,
                  'porcentaje_asistencia' => $array[$i][6],
                  'fpl1' => $array2[0][0],
                  'fordinario' => $array2[0][1],
               ]);
         } else if ($parciales == 2) {
            if ($array[$i][6] >= $calificiacion->calif_aprobatoria && $array[$i][6] <= $calificiacion->calif_maxima) {
               $status = 2;
            } else {
               $status = 3;
            }
            ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][0])
               ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
               ->update([
                  'pl1' => $array[$i][2],
                  'pl2' => $array[$i][3],
                  'ordinario' => $array[$i][4],
                  'final' => $array[$i][5],
                  'promedio_final' => $array[$i][6],
                  'status_aa' => $status,
                  'porcentaje_asistencia' => $array[$i][7],
                  'fpl1' => $array2[0][0],
                  'fpl2' => $array2[0][1],
                  'fordinario' => $array2[0][2],
               ]);
         } else if ($parciales == 3) {
            if ($array[$i][7] >= $calificiacion->calif_aprobatoria && $array[$i][7] <= $calificiacion->calif_maxima) {
               $status = 2;
            } else {
               $status = 3;
            }
            ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][0])
               ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
               ->update([
                  'pl1' => $array[$i][2],
                  'pl2' => $array[$i][3],
                  'pl3' => $array[$i][4],
                  'ordinario' => $array[$i][5],
                  'final' => $array[$i][6],
                  'promedio_final' => $array[$i][7],
                  'status_aa' => $status,
                  'porcentaje_asistencia' => $array[$i][8],
                  'fpl1' => $array2[0][0],
                  'fpl2' => $array2[0][1],
                  'fpl3' => $array2[0][2],
                  'fordinario' => $array2[0][3],
               ]);
         } else if ($parciales == 5) {
            if ($array[$i][9] >= $calificiacion->calif_aprobatoria && $array[$i][9] <= $calificiacion->calif_maxima) {
               $status = 2;
            } else {
               $status = 3;
            }
            ModeloAluGpoAsig::where('curp', '=', $curp)->where('clave_asignatura', '=', $array[$i][0])
               ->where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->where('clave_grupo', '=', $clave_grupo)
               ->update([
                  'pl1' => $array[$i][2],
                  'pl2' => $array[$i][3],
                  'pl3' => $array[$i][4],
                  'pl4' => $array[$i][5],
                  'pl5' => $array[$i][6],
                  'ordinario' => $array[$i][7],
                  'final' => $array[$i][8],
                  'promedio_final' => $array[$i][9],
                  'status_aa' => $status,
                  'porcentaje_asistencia' => $array[$i][10],
                  'fpl1' => $array2[0][0],
                  'fpl2' => $array2[0][1],
                  'fpl3' => $array2[0][2],
                  'fpl4' => $array2[0][3],
                  'fpl5' => $array2[0][4],
                  'fordinario' => $array2[0][5],
               ]);
         }
      }
      //consulta para ver si hay datos en los alumnos reprobados o no
      $consul = 'select DISTINCT curp from alumno_grupo_asignatura where observaciones != 1 and clave_grupo="' . $clave_grupo . '" and curp ="' . $curp . '"';
      $result = DB::select($consul);
      //aqui vamos a poner un if para ayudar a la redireccion
      if (sizeof($result) > 0) {
         $link = 'http://127.0.0.1:8000/calificacionExtra/' . encrypt($rvoe) . '/' . encrypt($vigencia) . '/' . encrypt($curp) . '/' . encrypt($clave_grupo);
      } else {
         $link = 'http://127.0.0.1:8000/alumnosCalificacion/' . encrypt($clave_grupo) . '/' . encrypt($rvoe) . '/' . encrypt($vigencia);
      } //return redirect()->route('alumnosCalificacion', ['clave_grupo' => encrypt($clave_grupo), 'rvoe' => encrypt($rvoe), 'vigencia' => encrypt($vigencia)]);
      return response()->json(["link" => $link]);
      //  return response()->json($array);
   }

   function sendArrayExtra(Request $request)
   {
      $array = $request->array;
      $rvoe = $request->rvoe;
      $clave_grupo = $request->clave_grupo;
      $vigencia = $request->vigencia;
      $curp = $request->curp;
      //$insert = [];

      for ($i = 0; $i < sizeof($array); $i++) {
         $afk = [
            "curp" => $curp,
            "clave_grupo" => $clave_grupo,
            "clave_asignatura" => $array[$i][0],
            "calificacion" => $array[$i][2],
            "fecha_aplicacion" => $array[$i][3],
            "rfc_docente" => $array[$i][4],
            "observaciones" => $array[$i][5],
            "rvoe" => $rvoe,
            "vigencia" => $vigencia
         ];
         $insert[] = $afk;
      }
      ModeloCalificacionesExtra::insert($insert);
      $link = 'http://127.0.0.1:8000/alumnosCalificacion/' . encrypt($clave_grupo) . '/' . encrypt($rvoe) . '/' . encrypt($vigencia);

      return response()->json(["link" => $link]);
   }
}
