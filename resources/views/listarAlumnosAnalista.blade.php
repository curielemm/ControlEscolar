@extends('layouts.app')
<title>ALUMNOS Analista</title>
@section('content')
<style>
  .my-custom-scrollbar {
    position: relative;
    height: 450px;
    overflow: auto;
  }

  .table-wrapper-scroll-y {
    display: block;
  }

  #divConta {
    max-width: 1400px;
  }
</style>

<div class="row">
  <div class="col-md-12 offset-md-12">
    <div class="card card-default">
      <h3 class="text-center">LISTA DE ALUMNOS DEL GRUPO </h3>
      <div class="card-header">
        <h4>Búsqueda de Alumno </h4>
        {{ Form::open(['', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

        <div class="form-group mb-2">
          {{Form::text('curp', null,['class'=>'form-control','placeholder'=>'CURP'])}}

        </div>
        <div class="form-group mx-sm-3 mb-2">
          {{Form::text('matricula', null,['class'=>'form-control','placeholder'=>'MATRÍCULA'])}}

        </div>
        <div class="form-group mx-sm-1 mb-2">
          <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
        </div>
        {{Form::close() }}

      </div>

      <div class="card-body">
        <div>
          <form method="get" action="{{'/panel'}}">
            <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
          </form>
        </div>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped">
            <thead class="thead-light">


              <tr>
                <th>#</th>
                <th>CURP</th>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Observaciones</th>

              </tr>

              @foreach($alumnos as $alumno)
              @if($alumno->status_inscripcion == 2) <tr class="table-warning">@endif
                @if($alumno->status_inscripcion == 1)
              <tr class="table-success">@endif
                <td>{{$loop->iteration}}</td>
                <td>{{$alumno->curp}}</td>
                <td>{{$alumno->matricula}}</td>
                <td>{{$alumno->nombre}}</td>
                <td>{{$alumno->apellido_paterno}}</td>
                <td>{{$alumno->apellido_materno}}</td>
                <td>{{$alumno->observaciones}}</td>
              </tr>
              @endforeach
          </table>
        </div>
        {{$alumnos->render()}}
        <a href="{{'/panel'}}">Regresar al Panel de Control</a>
        </thead>

      </div>

    </div>
  </div>
</div>
@endsection