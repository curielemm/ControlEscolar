@extends('layouts.app')
<title>Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-info">¡ASIGNATURA REGISTRADA CORRECTAMENTE!</h5>
            </div>
            <div class="card-body">
                <div>¿Desea agregar otra Asignatura?</div>
               <h5><a type="button" class="btn btn-info" href="FormularioMaterias">Agregar Asignatura</a></h5>
            </div>
               <a type="button" class="btn btn-info" href="panel">Panel de Control</a>
            </div>
        </div>
    </div>
</div>
@endsection
