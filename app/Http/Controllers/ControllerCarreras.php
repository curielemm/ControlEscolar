<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloCarrera;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Validator;

class ControllerCarreras extends Controller
{

  public function ver_formularioCarreras()
  {
     return view('InsertCarreras');

  }

  public function ver_formularioCarreras2()
  {
     return view('InsertCarreras2');

  }

  public function ver_CarrerasDinamico()
  {
     return view('CarrerasDinamico');

  }
  function insert(Request $request)
    {
     if($request->ajax())
     {
      $rules = array(
       'id_carrera.*'  => 'required',
       'no_revoe.*'  => 'required',
        'clave_cct.*'  => 'required',
         'nombre.*'  => 'required'
      );
      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $id_carrera = $request->id_carrera;
      $no_revoe = $request->no_revoe;
      $clave_cct = $request->clave_cct;
      $nombre = $request->nombre;
      for($count = 0; $count < count($id_carrera); $count++)
      {
       $data = array(
        'id_carrera' => $id_carrera[$count],
        'no_revoe'  => $no_revoe[$count],
        'clave_cct'  => $clave_cct[$count],
        'nombre'  => $nombre[$count]
       );
       $insert_data[] = $data;
      }

      ModeloCarrera::insert($insert_data);
      return response()->json([
       'success'  => 'Datos añadidos correctamente'
      ]);
     }
    }

}
