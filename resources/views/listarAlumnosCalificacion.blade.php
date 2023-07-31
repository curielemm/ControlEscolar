@extends('layouts.app')
<title>Alumnos Para Calificación</title>
@section('content')
<style>
    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 300px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h4 class="text-center">ALUMNOS DEL {{$grupo->no_periodo}}° GRUPO {{$grupo->nombre_grupo}} de {{$datos->nombre_plan}} vigencia {{$datos->vigencia}} </h4>
            <h5 class="text-center">Selecciona un Alumno para Asignar Calificación</h5>
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
                <h5>Simbología:</h5>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn bg-danger text-light" disabled>Alumno No Inscrito</button>   
                </div>
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
                                </tr>

                                @foreach($alumnos as $alumno)
                                @if($alumno->status_inscripcion != 1) <tr class="table-danger"> @endif
                                    @if($alumno->status_inscripcion == 1)
                                <tr> @endif

                                    <td>{{$loop->iteration}}</td>
                                    <td><a href="{{route('alumnoAsignaturas',[encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($alumno->curp),encrypt($grupo->clave_grupo)])}}">{{$alumno->curp}}</a></td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>

                </thead>

            </div>

        </div>
    </div>
</div>
@endsection