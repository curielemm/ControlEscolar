@extends('layouts.app')
<title>Lista de Planes</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">PLANES DE ESTUDIO DE {{$uno->nombre_institucion}}</h3>
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
                <h4>Búsqueda de Planes</h4>
                {{ Form::open(['route'=>['planes', $uno->clave_cct], 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('revoe', null,['class'=>'form-control','placeholder'=>'Ingresa el rvoe'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('nombre_plan', null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Licenciatura'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {!!Form::select('id_status', array('1' => 'Activo', '2' => 'Latencia','3'=>'Inactivo' ), null, ['class' => 'form-control'])!!}

                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
                {{Form::close() }}

            </div>
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
                            <th><button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button> Nombre de la Licenciatura, Maestría, Doctorado
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">Cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar clic sobre el plan de estudio puedes visualizar las vigencias de cada plan.
                                    </div>
                                </div>
                            </th>
                            <th>RVOE</th>
                            <th>Clave de Carrera DGP</th>
                            <th>Status</th>
                            <th>Ver DOF</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a data-title="Ver las vigencias del plan de estudios" href="{{route('detallePlan',[$planes->rvoe,$uno->clave_cct])}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_dgp}}</td>
                            <td>{{$planes->nombre_status}}</td>
                            @if($planes->dof!=null )
                            <td class="text-center"><a href="{{Storage::url($planes->dof)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->dof==null )
                            <td class="text-center"><i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </td>
                            @endif

                            <td>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <form action="{{ route('editarPlan',[$uno->clave_cct,$planes->rvoe])}}" method="get">
                                            {{csrf_field()}}

                                            <button data-title="Editar la información del plan de estudios" type="submit" class="btn btn-warning" onclick="return confirm('¿Editar?')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </form>
                                    </div>

                                    <!--form action="{{ route('eliminarPlan',$planes->rvoe)}}" method="post">
                                    {{csrf_field()}}

                                    <button type="submit" class=" btn-danger btn-block" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form -->
                                    <div class="col-md-4">
                                        <form action="{{ route('formActualizarPlanSU',[$uno->clave_cct,$planes->rvoe])}}" method="get">
                                            {{csrf_field()}}

                                            <button data-title="Agregar una actualización del plan de estudios" type="submit" class="btn btn-outline-success" onclick="return confirm('¿Actualizar?')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('listMat',$planes->rvoe)}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->descripcion}}</td>


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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('listMat',$planes->rvoe)}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->descripcion}}</td>


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
        <!--div>
            <a class="btn btn-danger" href="/pdf/{{$uno->clave_cct}}">Generar Ficha Técnica</a>
            <a class="btn btn-danger" href="/vistaFichaTec/{{$uno->clave_cct}}">Ver Ficha Técnica</a>
            <a class="btn btn-danger" href="/reportes">Generar Reporte de Institución</a>
        </div -->
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