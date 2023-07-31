@extends('layouts.app')
<title>Perfil Plan</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')



<div class="container">
    <div class="card">
        @if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session()->get('message1') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Perfil de "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif"</h1>
            <a href="{{route('listMatCtrl',[$datos->rvoe,$datos->vigencia])}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-home fa-sm text-white-50"></i> Ver Asignaturas</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Grupos</h5>
                            <p class="card-text">Ver los diferentes grupos de "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif" .</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('verGrupos',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Ver</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-dark" style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Nuevo Grupo</h5>
                            <p class="card-text">Permite agregar un nuevo grupo a "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif".</p>
                            <a style=" position: absolute; bottom: 2;" href="{{route('formGroup',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-dark " style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Inscribir Alumno</h5>
                            <p class="card-text">Inscribe alumnos a "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif" .</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('formularioalumnos',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Inscribir</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card text-white bg-dark " style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h5 class="card-title">Asignar Calificación</h5>
                            <p class="card-text">Asignar Calificación a los alumnos de "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
                                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif" .</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('verGruposCalificar',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Asignar</a>
                        </div>
                    </div>
                </div>

            </div>
            <p></p>
            <div class="row">
                <!--div class="col-sm-3">
                    <div class="card text-white bg-dark " style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h6 class="card-title">Asignar Calif. de Exámenes Extraordinarios</h6>
                            <p class="card-text">Asignar Calif. a los alumnos no Acreditados en el periodo ordinario .</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('verGruposCalificarExtra',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Asignar</a>
                        </div>
                    </div>
                </div-->

                <div class="col-sm-3">
                    <div class="card text-white bg-dark " style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h6 class="card-title">Baja de Alumnos</h6>
                            <p class="card-text">Dar de Baja a los Alumnos.</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('gruposBajaAlumnos',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Dar de Baja</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card text-white bg-dark " style="width: 15rem; height:200;">
                        <div class="card-body">
                            <h6 class="card-title">Reinscripción</h6>
                            <p class="card-text">Reinscripción de Alumnos en el periodo establecido</p>
                            <a style=" position: absolute; bottom: 2;" href="{{ route('gruposReinscripcion',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" class="btn btn-success">Reinscribir</a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<script>
    $('.alert').alert()
</script>
@endsection