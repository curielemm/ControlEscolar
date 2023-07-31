@extends('layouts.app')
<title>Lista de Planes de Mi Institucion Asignada</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">{{$institucion->nombre_institucion}}</h3>
            <h4 class="text-center">Actualizaciones del Plan {{$plan->nombre_plan}}</h4>
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
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
                            <th>Clave de Plan</th>
                            <th>Vigencia</th>
                            <th>Ver Plan de Estudios</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('perfilPlanAnalista',[encrypt($planes->rvoe),encrypt($institucion->clave_cct),encrypt($planes->vigencia)])}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_plan}}</td>
                            <td>{{$planes->vigencia}}</td>
                            @if($planes->archivo != null)
                            <td class="text-center"><a href="{{Storage::url($planes->archivo)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->archivo == null)
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
                            <th>Vigencia</th>
                            <th>Ver Plan de Estudios</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('perfilPlanAnalista',[encrypt($planes->rvoe),encrypt($institucion->clave_cct),encrypt($planes->vigencia)])}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->vigencia}}</td>
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