@extends('layouts.app')
<title>Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-info">¡ALUMNO REGISTRADO CORRECTAMENTE!</h5>
            </div>
            <div class="card-body">
                <div>¿Desea agregar otro Alumno?</div>
               <h5><a type="button" class="btn btn-info" href="formularioalumnos">Agregar otro Alumno</a></h5>
                <div>Regresar  </div>
               <h5><a type="button" class="btn btn-info" href="listarAlumnos">Lista de Alumnos</a></h5>
            </div>
             <div></div>
               <a type="button" class="btn btn-info" href="panel">Panel de Control</a>
            </div>
        </div>
    </div>
</div>
@endsection
