@extends('layouts.app')
<title>ALUMNOS</title>
@section('content')
<style>
  .my-custom-scrollbar {
    position: relative;
    height: 300px;
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
      <h3 class="text-center">LISTA DE ALUMNOS DEL {{$grupo->no_periodo}}° GRUPO {{$grupo->nombre_grupo}} de {{$datos->nombre_plan}} vigencia {{$datos->vigencia}} </h3>
      <div class="card-header">
        <h4>Busqueda de Alumno </h4>
        {{ Form::open(['', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

        <div class="form-group mb-2">
          {{Form::text('curp', null,['class'=>'form-control','placeholder'=>'CURP'])}}

        </div>
        <div class="form-group mx-sm-3 mb-2">
          {{Form::text('matricula', null,['class'=>'form-control','placeholder'=>'MATRICULA'])}}

        </div>
        <div class="form-group mx-sm-1 mb-2">
          <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
        </div>
        {{Form::close() }}

      </div>

      <div class="card-body">

        <div class="container-fluid">
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
                  <th>Acción</th>
                </tr>

                @foreach($alumnos as $alumno)

                @if($alumno->status_inscripcion == 2) <tr class="table-warning">@endif
                  @if($alumno->status_inscripcion == 1)
                <tr class="table-success">@endif
                  <td>{{$loop->iteration}}</td>
                  <td><a href="{{route('avance',[encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($alumno->curp),encrypt($grupo->clave_grupo)])}}">{{$alumno->curp}}</a></td>
                  <td>{{$alumno->matricula}}</td>
                  <td>{{$alumno->nombre}}</td>
                  <td>{{$alumno->apellido_paterno}}</td>
                  <td>{{$alumno->apellido_materno}}</td>
                  <td>{{$alumno->observaciones}}</td>
                  <td>
                    <div class="form-group row">
                      <div class="col-md-5">
                        <form action="{{route('editarAlumno',[$alumno->curp,$grupo->clave_grupo])}}" method="get">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-outline-warning"><i class="fa fa-pencil-square" aria-hidden="true"></i>
                          </button>
                        </form>
                      </div>
                      <!--div class="col-md-5">
                        <form action="" method="get">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                          </button>
                        </form>
                      </div -->
                    </div>
                  </td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
        {{$alumnos->render()}}
        </thead>

      </div>

    </div>
  </div>
</div>
@endsection