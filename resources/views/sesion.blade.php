@extends('layouts.login')
<title>Sesión No Iniciada</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-danger">¡No Haz Iniciado Sesión!</h5>
            </div>
            <div class="card-body">
               <a type="button" class="btn btn-info" href="/">Regresar al inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection