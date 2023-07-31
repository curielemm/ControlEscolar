<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloInsPlan;
use App\Models\ModeloPlan;
use App\Models\ModeloInstitucion;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Validator;

class ControllerInsPlan extends Controller
{

  public function ver_IPDinamico()
  {
     return view('InsPlaDinamico');

  }




  function insert(Request $request)
    {
     if($request->ajax())
     {
      $rules = array(
       'clave_cct.*'  => 'required',
       'clave_plan.*'  => 'required',
      );

      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $clave_cct = $request->clave_cct;
      $clave_plan = $request->clave_plan;

      


      for($count = 0; $count < count($clave_cct); $count++)
      {
       $data = array(
        'clave_cct' => $clave_cct[$count],
        'clave_plan'  => $clave_plan[$count]

       );
       $insert_data[] = $data;
      }

      ModeloInsPlan::insert($insert_data);
      return response()->json([
       'success'  => 'Datos añadidos correctamente'
      ]);
     }
    }


    function ver_instituciones(Request $var){
      //$consulta =   ModeloCarrera::get(['nombre']);
      //return $consulta;
      $escuela = ModeloInstitucion::all();
      $plan['plan'] = ModeloPlan::all();
      return view('InsPlanDinamico',compact('escuela'),$plan);

      }


    public function listado_inst($escuela)
  {
    $consulta = ModeloInstitucion::select('nombre_institucion','clave_cct')
               ->where('nombre_institucion',$escuela)->get();
    return $consulta;
  }

}
