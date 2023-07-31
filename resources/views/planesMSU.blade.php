@extends('layouts.app')
<title>Lista de Planes MSU</title>
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
            <div class="card-header">
                <h4>Búsqueda de Planes</h4>
                {{ Form::open(['route'=>['planesMSU', $uno->clave_cct], 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('revoe', null,['class'=>'form-control','placeholder'=>'Ingresa el rvoe'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {!!Form::select('tipo', array(''=>'Seleccione una opción','1' => 'Bachillerato General', '2' => 'Profesional Técnico','3'=>'Bachillerato Tecnológico' ), null, ['class' => 'form-control'])!!}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {!!Form::select('id_status', array(''=>'Seleccione una opción','1' => 'Activo', '2' => 'Latencia','3'=>'Inactivo' ), null, ['class' => 'form-control'])!!}

                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
                {{Form::close() }}

            </div>
            <div class="card-body">
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/listarInstitucionMSU'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-university" aria-hidden="true">Regresar a Institucion</span>
                    </form>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre del Bachillerato</th>
                            <th>RVOE</th>
                            <th>Vigencia</th>
                            <th>Modalidad</th>
                            <th>Status</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{ route('asignaturas',$planes->rvoe_msu)}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe_msu}}</td>
                            <td>{{$planes->vigencia}}</td>
                            <td>{{$planes->nombre_modalidad}}</td>
                            <td>{{$planes->nombre_status}}</td>

                            <td>
                                <form action="{{ route('editarPlan',[$uno->clave_cct,$planes->rvoe_msu])}}" method="get">
                                    {{csrf_field()}}

                                    <button type="submit" class=" btn-warning btn-block" onclick="return confirm('Editar?')">Editar</button>
                                </form>
                                <form action="{{ route('eliminarPlan',$planes->rvoe_msu)}}" method="post">
                                    {{csrf_field()}}

                                    <button type="submit" class=" btn-danger btn-block" onclick="return confirm('Eliminar?')">Eliminar</button>
                                </form>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$datos->render()}}
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/listarInstitucionMSU'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-university" aria-hidden="true">Regresar a Institucion</span>
                    </form>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>

            </div>
        </div>
        <a class="btn btn-danger" href="/pdf/{{$uno->clave_cct}}">Generar Ficha Tecnica</a>
        <a class="btn btn-danger" href="/vistaFichaTec/{{$uno->clave_cct}}">Ver Ficha Tecnica</a>

    </div>

</div>

@endsection
