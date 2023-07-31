@extends('layouts.app')
<title>Mis Instituciones Asignadas</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">MIS INSTITUCIONES ASIGNADAS</h3>
            <div class="card-header">
                @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('message2'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session()->get('message2') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <h4>Búsqueda de Institución </h4>
                {{ Form::open(['route'=>'misInstituciones', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('institucion', null,['class'=>'form-control','placeholder'=>'Institucion'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('clave_cct', null,['class'=>'form-control','placeholder'=>'Clave cct'])}}

                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
                {{Form::close() }}

            </div>
            <div class="card-body">
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>

                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Institución <button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar clic sobre el nombre de la Institución puedes visualizar cada uno de sus planes de estudio.
                                    </div>
                                </div>
                            </th>
                            <th>Clave de Centro de Trabajo</th>
                            <th>Clave de Institución DGP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $datitos)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a data-title="Da clic aquí para ver la información de los planes de estudio" href="planesAsig/{{encrypt($datitos->clave_cct)}}">{{$datitos->nombre_institucion}}</a></td>
                            <td>{{$datitos->clave_cct}}</td>
                            <td>{{$datitos->clave_dgpi}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$datos->render()}}
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