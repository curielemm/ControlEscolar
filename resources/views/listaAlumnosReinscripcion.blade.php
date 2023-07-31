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
            <div>
                <form action="{{route('reinscripcionAlumnos',[encrypt($grupo->clave_grupo),encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" method="get">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                        Regresar
                    </button>
                </form>
            </div>
            <div class="card-header">
                <h5 class="text-center">"Selecciona a un alumno para agregar las asignaturas susceptibles a cursar"</h5>
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                @if(session()->has('message2'))
                <div class="alert alert-danger">
                    {{ session()->get('message2') }}
                </div>
                @endif
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
                                    <th>Remover del Grupo</th>
                                </tr>

                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><a href="{{route('cargaAsignaturasReinscripcion',[encrypt($alumno->curp),encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($grupo->clave_grupo)])}}">{{$alumno->curp}}</a></td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                    <td>
                                        <div>
                                            <form action="{{route('removerdegrupo',[encrypt($alumno->curp),encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($grupo->clave_grupo)])}}" method="get">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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