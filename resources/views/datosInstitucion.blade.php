@extends('layouts.app')
<title>Instituciones Nivel Superior</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')

<div class="container">
    <div class="row">
        <div class="card card-default">
            <h3 class="text-center">Instituciones de Nivel Superior</h3>
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
                <h4>Búsqueda de Institución </h4>
                {{ Form::open(['route'=>'listarInstitucion', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('institucion', null,['class'=>'form-control','placeholder'=>'Institución', 'onkeyup' =>'javascript:this.value=this.value.toUpperCase();countChars(this);'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('clave_cct', null,['class'=>'form-control','placeholder'=>'Clave cct','onkeyup' =>'javascript:this.value=this.value.toUpperCase();countChars(this);'])}}

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
                            <th>Dirección</th>
                            <th>Página Web</th>
                            <th>Nivel</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($institucion as $institucioness)
                        <tr>
                            <td>{{$loop->iteration}}
                            </td>
                            <td><a data-title="Da clic aquí para ver la información de los planes de estudio" href="planes/{{$institucioness->clave_cct}}">{{$institucioness->nombre_institucion}}</a></td>
                            <td>{{$institucioness->clave_cct}}</td>
                            <td>{{$institucioness->clave_dgpi}}</td>
                            <td>{{$institucioness->municipio}}, Col.{{$institucioness->colonia}}, Calle:{{$institucioness->calle}},
                                Num Ext:{{$institucioness->numero_exterior}}, Num. Int:{{$institucioness->numero_interior}}, Cp:{{$institucioness->codigo_postal}} </td>
                            <td>{{$institucioness->pagina_web}}</td>
                            <td>{{$institucioness->nombre_tipo_institucion}}</td>
                            <td>

                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <form action="{{ route('editarInstitucion',$institucioness->clave_cct)}}" method="get">
                                            {{csrf_field()}}
                                            <button data-title="Editar la información de la institución" type="submit" class="btn btn-outline-success btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-5">
                                        <form action="{{ route('eliminarInstitucion',$institucioness->clave_cct)}}" method="get">
                                            {{csrf_field()}}
                                            <button data-title="Eliminar la información de la institución" type="submit" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$institucion->render()}}
                <div>Total de Instituciones de Nivel Superior: {{$TotalInstituciones}} </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
            </div>
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