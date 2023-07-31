@extends('layouts.app')
<title>Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-info">¡GRUPO REGISTRADO CORRECTAMENTE!</h5>
            </div>
            <div class="card-body">
                <div>¿Desea agregar otro Grupo?</div>
                <h5><a type="button" class="btn btn-info" href="{{route('formGroup',[encrypt($rvoe),encrypt($vigencia)])}}">Agregar otro Grupo</a></h5>
                <div>Regresar </div>
                <h5><a type="button" class="btn btn-info" href="{{route('verGrupos',[encrypt($rvoe),encrypt($vigencia)])}}">Lista de Grupos</a></h5>
                <div>Regresar al perfil </div>
                <h5><a type="button" class="btn btn-info" href="{{route('perfilPlan',[encrypt($rvoe),encrypt($vigencia)])}}">Regresar al Perfil</a></h5>
            </div>
            <div></div>
            <a type="button" class="btn btn-info" href="panel">Panel de Control</a>
        </div>
    </div>
</div>
</div>
@endsection