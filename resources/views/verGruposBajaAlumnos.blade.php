@extends('layouts.app')
<title>Lista de Grupos</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    .my-custom-scrollbar {
        position: relative;
        height: 300px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">GRUPOS DE "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif" </h3>
            <div class="card-header">
                <h4 class="text-center">Grupos del Ciclo Escolar {{$ciclo_actual->id_ciclo_escolar}}</h4>
                <h5 class="text-center">Selecciona un grupo para dar de baja a un alumno</h5>
            </div>

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
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered border-primary">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Clave de Grupo</th>
                                <th>Nombre de Grupo</th>
                                <th>@if($datos->id_duracion == 1){{'Año'}} @endif
                                    @if($datos->id_duracion == 2){{'Semestre'}} @endif
                                    @if($datos->id_duracion == 3){{'Cuatrimestre'}} @endif
                                    @if($datos->id_duracion == 4){{'Trimestre'}} @endif
                                    @if($datos->id_duracion == 5){{'Bimestre'}} @endif</th>
                                <th>Periodo Escolar</th>
                                <th>Turno</th>
                                <th>Ciclo Escolar</th>
                              
                            
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupos as $grupo)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('listarAlumnosBaja',[encrypt($grupo->clave_grupo),encrypt($datos->rvoe),encrypt($datos->vigencia)])}}">{{$grupo->clave_grupo}}</a></td>
                                <td class="text-center">{{$grupo->nombre_grupo}}</td>
                                <td>{{$grupo->no_periodo}}</td>
                                <td>
                                    {{$grupo->fecha_ini}}/{{$grupo->fecha_fin}}
                                </td>
                                <td>{{$grupo->nombre_turno}}</td>
                                <td>{{$grupo->fk_clave_ciclo_escolar}}</td>
                               
                            

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                {{$grupos->render()}}
            </div>
        </div>
    </div>
</div>

@endsection