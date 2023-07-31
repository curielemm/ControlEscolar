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
                <!--h4>Búsqueda de Grupo </h4>
                <form action="{{route('verGrupos',[$datos->rvoe,$datos->vigencia])}}" method="GET" class="form-inline pull-right">
                    <div class="form-group row">
                        <label class="col-sm-6 ">Seleccione Ciclo Escolar:</label>
                        <div class="col-sm-6">
                            <select name="ciclo_escolar" id="ciclo_escolar" class="form-control">
                                @foreach($ciclos as $ciclo)
                                <option value="{{$ciclo->id_ciclo_escolar}}">{{$ciclo->id_ciclo_escolar}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('clave_grupo','<small class="text-danger">:message</small><br>') !!}
                        </div>
                    </div>
                    <div class="form-group mx-sm-1 mb-2">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                    </div>
                </form-->
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupos as $grupo)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('listarAlumnos',[encrypt($grupo->clave_grupo),encrypt($datos->rvoe),encrypt($datos->vigencia)])}}">{{$grupo->clave_grupo}}</a></td>
                                <td class="text-center">{{$grupo->nombre_grupo}}</td>
                                <td>{{$grupo->no_periodo}}</td>
                                <td>
                                    {{$grupo->fecha_ini}}/{{$grupo->fecha_fin}}
                                </td>
                                <td>{{$grupo->nombre_turno}}</td>
                                <td>{{$grupo->fk_clave_ciclo_escolar}}</td>
                                <td>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <form action="{{route('editarFormGrupo',[encrypt($datos->rvoe),encrypt($grupo->clave_grupo),encrypt($datos->vigencia)])}}" method="get">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-warning" onclick="return confirm('¿Editar?')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="{{route('eliminarGrupo',[$grupo->clave_grupo,$datos->rvoe,$datos->vigencia])}}" method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="ciclo_escolar" id="ciclo_escolar" value="{{$grupo->fk_clave_ciclo_escolar}}">
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar?')"><i class="fa fa-trash center" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <!--div class="col-md-3">
                                            <form action="" method="post">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-success" onclick="return confirm('Agregar Materias?')"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div-->
                                    </div>
                                </td>

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