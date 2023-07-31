@extends('layouts.app')
<title>Logs del sistema</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')
<div class="container">
    <div class="row">
        <div class="card card-default">
            <h3 class="text-center">Modificaciones en el sistema</h3>
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
            <!--div class="card-header">
                <h4>Búsqueda de Logs </h4>
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

            </div-->
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
                            <th>Clave Usuario</th>
                            <th>Correo Usuario</th>
                            <th>Campo de Trabajo</th>
                            <th>Acción</th>
                            <th>Valor Actual</th>
                            <th>Valor Anterior</th>
                            <th>Fecha</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bitacora as $elementos)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$elementos->clave_usuario}}</td>
                            <td>{{$elementos->correo_usuario}}</td>
                            <td>{{$elementos->nombre_tabla}}</td>
                            <td>{{$elementos->accion}}</td>
                            <td>{{$elementos->valor_actual}}</td>
                            <td>{{$elementos->valor_anterior}}</td>
                            <td> {{$elementos->fecha}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$bitacora->render()}}
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