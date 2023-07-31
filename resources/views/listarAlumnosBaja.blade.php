@extends('layouts.app')
<title>Baja de Alumnos</title>
@section('content')
<style>
    .my-custom-scrollbar {
        position: relative;
        height: 350px;
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
                <h4 class="text-center">Selecciona a un alumno para dar de baja de la carrera </h4>
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

                                <tr>
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
                                                <form action="{{route('bajaAlumno')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
                                                    <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">
                                                    <input type="hidden" id="rvoe" name="rvoe" value="{{$datos->rvoe}}">
                                                    <input type="hidden" id="vigencia" name="vigencia" value="{{$datos->vigencia}}">
                                                    <input type="hidden" id="tipo" name="tipo" value="1">
                                                    <button data-title="Baja temporal" type="submit" class="btn btn-outline-warning"><i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-5">
                                                <form action="{{route('bajaAlumno')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
                                                    <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">
                                                    <input type="hidden" id="rvoe" name="rvoe" value="{{$datos->rvoe}}">
                                                    <input type="hidden" id="vigencia" name="vigencia" value="{{$datos->vigencia}}">
                                                    <input type="hidden" id="tipo" name="tipo" value="2">
                                                    <button type="submit" data-title="Baja definitiva" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
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