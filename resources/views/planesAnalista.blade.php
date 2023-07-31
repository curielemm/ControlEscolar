@extends('layouts.app')
<title>Lista de Planes de Mi Institucion Asignada</title>
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
                {{ Form::open(['route'=>['planesAsig', $uno->clave_cct], 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

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
                    <a href="{{URL::previous()}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-home fa-sm text-white-50"></i> Regresar atras</a>

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
                            <th>Nombre de la Licenciatura, Maestria, Doctorado</th>
                            <th>Rvoe</th>
                            <th>Clave DGP</th>
                            <th>Ver DOF</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('detallePAnalista',[encrypt($planes->rvoe),encrypt($uno->clave_cct)])}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_dgp}}</td>
                            @if($planes->dof != null)
                            <td class="text-center"><a href="{{Storage::url($planes->dof)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->dof == null)
                            <td class="text-center"><i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </td>
                            @endif


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
                            <td><a href="{{route('detallePAnalista',[$planes->rvoe,$uno->clave_cct])}}">{{$planes->nombre_nivel_educativo}}</a></td>
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
                            <th>Nombre del Plan</th>
                            <th>Clave Plan</th>
                            <th>Rvoe</th>
                            <th>Vigencia</th>
                            <th>No. Creditos</th>
                            <th>Duración de Ciclo</th>
                            <th>Descripción</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$planes->nombre_plan}}</td>
                            <td>{{$planes->revoe}}</td>
                            <td>{{$planes->vigencia}}</td>
                            <td>{{$planes->no_creditos}}</td>
                            <td>{{$planes->duracion_ciclo}}</td>
                            <td>{{$planes->descripcion}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                {{$datos->render()}}
                <div class="form-inline pull-right">
                    <a href="{{URL::previous()}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-home fa-sm text-white-50"></i> Regresar atras</a>

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

@endsection