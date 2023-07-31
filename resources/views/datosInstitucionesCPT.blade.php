@extends('layouts.app')
<title>Instituciones de Capacitación Para el Trabajo</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')
<div class="container">
    <div class="row">
        <div class="card card-default">
            <h3 class="text-center">Instituciones de Capacitación para el Trabajo</h3>
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            @if(session()->has('message2'))
            <div class="alert alert-success">
                {{ session()->get('message2') }}
            </div>
            @endif
            <div class="card-header">
                <h4>Búsqueda de Institución </h4>
                {{ Form::open(['route'=>'listarInstitucionCPT', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

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
                <table class="table table-light table-hover table-striped table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Institución</th>
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
                            <td>{{$loop->iteration}}</td>
                            <td><a href="planes/{{$institucioness->clave_cct}}">{{$institucioness->nombre_institucion}}</a></td>
                            <td>{{$institucioness->clave_cct}}</td>
                            <td>{{$institucioness->clave_dgpi}}</td>
                            <td>{{$institucioness->municipio}}, Col.{{$institucioness->colonia}}, Calle:{{$institucioness->calle}},
                                Num Ext:{{$institucioness->numero_exterior}}, Num. Int:{{$institucioness->numero_interior}}, Cp:{{$institucioness->codigo_postal}} </td>
                            <td>{{$institucioness->pagina_web}}</td>
                            <td>{{$institucioness->nombre_tipo_institucion}}</td>
                            <td>
                                <form action="{{ route('editarInstitucion',$institucioness->clave_cct)}}" method="get">
                                    {{csrf_field()}}
                                    <button type="submit" class=" btn-success btn-block">Editar</button>
                                </form>
                                <form action="{{ route('eliminarInstitucion',$institucioness->clave_cct)}}" method="get">
                                    {{csrf_field()}}
                                    <button type="submit" class=" btn-danger btn-block">Eliminar</button>
                                </form>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$institucion->render()}}
                <div>Total de Instituciones de Capacitación para el Trabajo: {{$TotalInstituciones}} </div>
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

@endsection
