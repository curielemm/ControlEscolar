@extends('layouts.app')
<title>Detalle Plan</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">{{$institucion->nombre_institucion}}</h3>
            <h3 class="text-center">Actualizaciones del Plan {{$plan->nombre_plan}} RVOE: {{$plan->rvoe}}</h3>
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

            <div class="card-body">
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/instituciones'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-university" aria-hidden="true">Regresar a Institución</span>
                    </form>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
                @if($nivel == 1)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th class="text-center"><button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button> Nombre de la Licenciatura, Maestría, Doctorado
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">Cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar clic sobre el plan de estudio puedes visualizar las asignaturas de cada vigencia.
                                    </div>
                                </div>
                            </th>
                            <th>RVOE</th>
                            <th>Clave Plan</th>
                            <th>Vigencia</th>
                            <th>Modalidad</th>
                            <th>Status</th>
                            <th>Ver Plan</th>
                            <th>Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a data-title="Ver las asignaturas de este plan de estudios" href="{{route('listMat',[$planes->rvoe,$planes->vigencia])}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_plan}}</td>
                            <td>{{$planes->vigencia}}</td>
                            <td>{{$planes->nombre_modalidad}}</td>
                            <td>{{$planes->nombre_status}}</td>
                            @if($planes->archivo != null)
                            <td class="text-center"><a href="{{Storage::url($planes->archivo)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->archivo == null)
                            <td class="text-center"><i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </td>
                            @endif
                            <td class="text-center">
                                <form action="{{route('editPlanActu',[$institucion->clave_cct, $planes->rvoe, $planes->vigencia])}}" method="get">
                                    {{csrf_field()}}

                                    <button data-title="Editar la información de este plan de estudios" type="submit" class="btn btn-warning " onclick="return confirm('¿Editar?')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if($nivel==2)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tipo de Bachillerato</th>
                            <th>Rvoe</th>
                            <th>Descripcion</th>
                            <th>Vigencia</th>
                            <th>Ver Plan</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->descripcion}}</td>
                            <td>{{$planes->vigencia}}</td>
                            <td class="text-center"><a href="{{Storage::url($planes->archivo)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>

                            <td>
                                <form action="{{ route('editarPlan',[$uno->clave_cct,$planes->rvoe])}}" method="get">
                                    {{csrf_field()}}

                                    <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('¿Editar?')">Editar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if($nivel==3)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tipo de Capacitación Para El Trabajo</th>
                            <th>Rvoe</th>
                            <th>Descripcion</th>
                            <th>Vigencia</th>
                            <th>Ver Plan</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->descripcion}}</td>
                            <td>{{$planes->vigencia}}</td>
                            <td class="text-center"><a href="{{Storage::url($planes->archivo)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            <td>
                                <form action="{{ route('editarPlan',[$uno->clave_cct,$planes->rvoe])}}" method="get">
                                    {{csrf_field()}}

                                    <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('¿Editar?')">Editar</button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                {{$datos->render()}}
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/listarInstitucion'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-university" aria-hidden="true">Regresar a Institución</span>
                    </form>
                </div>
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
                delay: 500000
            });
            $('.toast').toast('show');
        });
    });
</script>
@endsection