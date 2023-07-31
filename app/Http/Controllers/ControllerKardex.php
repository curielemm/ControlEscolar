<?php

namespace App\Http\Controllers; //se declara el controlador




// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;



use Validator;

class ControllerKardex extends Controller
{


  public function ver_Kardex()
  {
    return view('kardex');
  }

}
