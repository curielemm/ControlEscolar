@extends('layouts.login')
<title>Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-danger">¡Ya has sido registrado!</h5>
            </div>
            <div class="card-body">
                <div>Se te notificará vía correo electrónico que has sido autorizado para usar el sistema</div>
               <a type="button" class="btn btn-info" href="/">Regresar al inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection
