@extends('layouts.app')
<title>Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-danger">¡DATOS REGISTRADOS CORRECTAMENTE!</h5>
            </div>
            <div class="card-body">
                <div>¿Desea agregar otro Plan de Estudio?</div>
               <h5><a type="button" class="btn btn-danger" href="PlanesMSU">Agregar otro Plan</a></h5>
                <div>Registrar Asignaturas de Este Plan </div>
               <h5><a type="button" class="btn btn-danger" href="FormularioMateriaMSU">Asignatura MSU</a></h5>
            </div>

               <a type="button" class="btn btn-danger" href="panel">Panel de Control</a>
            </div>
        </div>
    </div>
@endsections
