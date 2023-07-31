<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloDirector;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Validator;

class ControllerDirector extends Controller
{


  public function ver_DirectorDinamico()
  {
     return view('DirectorDinamico');

  }
  
  function insert(Request $request)
    {
     if($request->ajax())
     {
      $rules = array(
       'clave_director.*'  => 'required',
       'nombre_pila.*'  => 'required',
       'apellido_paterno.*'  => 'required',
        'apellido_materno.*'  => 'required',
        'correo.*'  => 'required'
      );

      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $clave_director = $request->clave_director;
      $nombre_pila = $request->nombre_pila;
      $apellido_paterno = $request->apellido_paterno;
      $apellido_materno = $request->apellido_materno;
      $correo = $request->correo;
      


      for($count = 0; $count < count($clave_director); $count++)
      {
       $data = array(
        'clave_director' => $clave_director[$count],
        'nombre_pila'  => $nombre_pila[$count],
        'apellido_paterno'  => $apellido_paterno[$count],
        'apellido_materno'  => $apellido_materno[$count],
        'correo'  => $correo[$count]

       );
       $insert_data[] = $data;
      }

      ModeloDirector::insert($insert_data);
      return response()->json([
       'success'  => 'Datos añadidos correctamente'
      ]);
     }
    }

}
