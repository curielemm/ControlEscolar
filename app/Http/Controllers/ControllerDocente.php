<?php

namespace App\Http\Controllers; //se declara el controlador

use App\Models\ModeloDocente;

// se agrega libreria para ejecutar el request
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Models\InstitucionDocente;
use App\Models\ModeloInstitucion;
use Validator;

class ControllerDocente extends Controller
{


  public function formDocente()
  {
    $clave_institucion = auth()->user()->institucion;
    $institucion = ModeloInstitucion::select('nombre_institucion')->where('clave_cct', '=', $clave_institucion)
      ->take(1)
      ->first();

    return view('registroDocente', compact('institucion'));
  }

  public function agregarDocente(Request $var)
  {
    $clave_institucion = auth()->user()->institucion;
    request()->validate([

      'rfc' => ['required', 'string', 'min:5', 'max:10'],
      'nombre' => ['required', 'string', 'min:3', 'max:150'],
      'apellido_paterno' => ['required', 'string', 'min:3', 'max:150'],
      'apellido_materno' => ['required', 'string', 'min:3', 'max:150'],
      'correo' => ['required', 'string', 'min:5', 'max:150'],
      'telefono' => ['required', 'string', 'min:5', 'max:10']

    ]);

    $rfc = $var->input('rfc');
    $nombre = $var->input('nombre');
    $apellido_paterno = $var->input('apellido_paterno');
    $apellido_materno = $var->input('apellido_materno');
    $correo = $var->input('correo');
    $telefono = $var->input('telefono');

    $docentes = ModeloDocente::select('rfc')
      ->where('rfc', '=', $rfc)
      ->take(1)
      ->first();


    if ($docentes == null) {
      ModeloDocente::create([
        'rfc' => $rfc, 'nombre' => $nombre, 'apellido_paterno' => $apellido_paterno,
        'apellido_materno' => $apellido_materno, 'correo' => $correo,
        'telefono' => $telefono
      ]);
    }

    $docentesInstituciones = InstitucionDocente::select('rfc', 'clave_cct')
      ->where('rfc', '=', $rfc)->where('clave_cct', '=', $clave_institucion)
      ->take(1)
      ->first();

    if ($docentesInstituciones == null) {
      InstitucionDocente::create([
        'rfc' => $rfc,
        'clave_cct' => $clave_institucion,
        'estatus' => 1
      ]);
      return redirect()->back()->with('message1', 'Docente Agregado Correctamente');
    } else {
      //Hacemos el update
      InstitucionDocente::where('clave_cct', '=', $clave_institucion)
        ->where('rfc', '=', $rfc)
        ->update(['estatus' => 1]);
      return redirect()->back()->with('message1', 'Docente Agregado Correctamente');
    }
  }

  public function listarDocentes()
  {
    $clave_cct = auth()->user()->institucion;
    $docentes = ModeloDocente::select(
      'docente.rfc',
      'nombre',
      'apellido_paterno',
      'apellido_materno',
      'correo',
      'telefono'
    )->join('institucion_docente', 'institucion_docente.rfc', '=', 'docente.rfc')
      ->where('institucion_docente.clave_cct', '=', $clave_cct)
      ->where('institucion_docente.estatus', '=', 1)
      ->paginate(5);

    $institucion = ModeloInstitucion::select('nombre_institucion')->where('clave_cct', '=', $clave_cct)
      ->take(1)
      ->first();

    return view('listarDocentes', compact('docentes', 'clave_cct','institucion'));
  }

  public function eliminarDocente($rfc, $clave_cct)
  {
    InstitucionDocente::where('clave_cct', '=', $clave_cct)
      ->where('rfc', '=', $rfc)
      ->update(['estatus' => 2]);
    return redirect()->back()->with('message1', 'Docente Eliminado Correctamente');
  }
}
