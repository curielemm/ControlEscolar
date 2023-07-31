@extends('layouts.app')
<title>Alumnos No Acreditados</title>
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
            <h5 class="text-center">Selecciona un Alumno para ver las asignaturas reprobadas</h5>
            <div class="card-header">
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
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><a href="{{route('calificacionExtra',[encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($alumno->curp),encrypt($grupo->clave_grupo)])}}">{{$alumno->curp}}</a></td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
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