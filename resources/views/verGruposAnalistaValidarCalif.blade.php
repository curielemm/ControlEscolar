@extends('layouts.app')
<title>Grupos</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h2 class="text-center">{{$institucion->nombre_institucion}}</h2>
            <h3 class="text-center">GRUPOS DE "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}}@endif
                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}}@endif"</h3>
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
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/instituciones'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-university" aria-hidden="true">Regresar a Planes</span>
                    </form>
                </div>
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Clave de Grupo <button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">Cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar clic sobre la clave del grupo puedes visualizar la lista de los alumnos del grupo.
                                    </div>
                                </div>
                            </th>
                            <th>Nombre de Grupo</th>
                            <th>@if($datos->id_duracion == 1){{'Año'}} @endif
                                @if($datos->id_duracion == 2){{'Semestre'}} @endif
                                @if($datos->id_duracion == 3){{'Cuatrimestre'}} @endif
                                @if($datos->id_duracion == 4){{'Trimestre'}} @endif
                                @if($datos->id_duracion == 5){{'Bimestre'}} @endif</th>
                            <th>Periodo Escolar</th>
                            <th>Turno</th>
                            <th>Ciclo Escolar</th>
                            <th>Acreditación PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a data-title="Ver los alumnos del grupo" href="{{route('asignaturasCalificacion',[encrypt($grupo->clave_grupo), encrypt($grupo->no_periodo), encrypt($datos->vigencia), encrypt($datos->rvoe)])}}">{{$grupo->clave_grupo}}</a>
                                <input type="hidden" name="clave_grupo" id="clave_grupo" value="{{$grupo->clave_grupo}}" style="visibility:hidden;">
                            </td>
                            <td>{{$grupo->nombre_grupo}}
                                <input type="hidden" name="rvoe" id="rvoe" value="{{$datos->rvoe}}" style="visibility:hidden;">
                            </td>
                            <td class="text-center">{{$grupo->no_periodo}}
                                <input type="hidden" name="clave_cct" id="clave_cct" value="{{$grupo->clave_cct}}" style="visibility:hidden;">
                            </td>
                            <td>{{$grupo->fecha_ini}}/{{$grupo->fecha_fin}}</td>
                            <td>{{$grupo->nombre_turno}}</td>
                            <td>{{$grupo->fk_clave_ciclo_escolar}}</td>
                            <td>
                                <div class="col-md-5">
                                    <form id="acuse{{$loop->iteration}}" name="acuse{{$loop->iteration}}" action="{{route('acuseAcreditacion',[$grupo->clave_grupo,$datos->rvoe,$institucion->clave_cct,$datos->vigencia])}}" method="get">
                                        <button id="pdf" name="pdf" na data-title="Generar Acuse de Validación" class="btn btn-outline-danger" onclick="return confirm('El acuse se puede generar sólo una vez, en caso de ya haber sido generado antes se mostrará el archivo con la fecha y hora del momento de la generación.¿Desea Continuar?')">
                                            <span class="fa fa-file-pdf-o" aria-hidden="true"> </span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$grupos->render()}}
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(document).on('click', '#info', function() {
            $(".toast").toast({
                autohide: true,
                delay: 10000
            });
            $('.toast').toast('show');
        });
    });
</script>
@endsection