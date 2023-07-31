@extends('layouts.app')
<title>Perfil Plan Analista</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')



<div class="container">
    <div class="card">
        <h1>{{$institucion->nombre_institucion}}</h1>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h2 class="h3 mb-0 text-gray-800">Perfil de "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif"</h2>
            <a href="{{URL::previous()}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-home fa-sm text-white-50"></i> Regresar atras</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Grupos</h5>
                            <p class="card-text">Ver los diferentes grupos de "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif" .</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('verGruposAnalista',[$datos->rvoe,$institucion->clave_cct,$datos->vigencia])}}" class="btn btn-success">Ver</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Validar Inscripción</h5>
                            <p class="card-text">Validar la inscripción de Alumnos @if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('verGruposAnalista',[$datos->rvoe,$institucion->clave_cct,$datos->vigencia])}}" class="btn btn-success">Validar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Validar Equivalencia ó Revalidacion</h5>
                            <p class="card-text">Validar documentación de Alumnos @if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('gruposEquivalencia',[encrypt($datos->rvoe),encrypt($institucion->clave_cct),encrypt($datos->vigencia)])}}" class="btn btn-success">Validar</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Validar Acreditación</h5>
                            <p class="card-text">Validar las Calificaciones de Alumnos @if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('gruposValidarCalificacion',[$datos->rvoe,$institucion->clave_cct,$datos->vigencia])}}" class="btn btn-success">Validar</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection