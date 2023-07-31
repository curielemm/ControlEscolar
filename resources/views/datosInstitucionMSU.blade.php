@extends('layouts.app')
<title>Instituciones Nivel Medio Superior</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
</style>
<div class="container">
    <div class="row">
        <div class="card card-default">
            <h3 class="text-center">Instituciones de Nivel Media Superior</h3>
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
                {{ Form::open(['route'=>'listarInstitucionMSU', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('institucion', null,['class'=>'form-control','placeholder'=>'Institucion','onkeyup' =>'javascript:this.value=this.value.toUpperCase();countChars(this);'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('clave_cct', null,['class'=>'form-control','placeholder'=>'Clave cct', 'onkeyup' =>'javascript:this.value=this.value.toUpperCase();countChars(this);'])}}

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
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre de la Institución</th>
                                <th>Clave de Centro de Trabajo</th>
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
                                <td><a href="planesMSU/{{$institucioness->clave_cct}}">{{$institucioness->nombre_institucion}}</a></td>
                                <td>{{$institucioness->clave_cct}}</td>
                                <td>{{$institucioness->municipio}}, Col.{{$institucioness->colonia}}, Calle:{{$institucioness->calle}},
                                    Num Ext:{{$institucioness->numero_exterior}}, Num. Int:{{$institucioness->numero_interior}}, Cp:{{$institucioness->codigo_postal}} </td>
                                <td>{{$institucioness->pagina_web}}</td>
                                <td>{{$institucioness->nombre_tipo_institucion}}</td>
                                <td>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <form action="{{ route('editarInstitucionMSU',$institucioness->clave_cct)}}" method="get">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-md-5">
                                            <form action="{{ route('eliminarInstitucion',$institucioness->clave_cct)}}" method="get">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
      
                <div>Total de Instituciones de Media Superior: {{$TotalInstituciones}} </div>
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