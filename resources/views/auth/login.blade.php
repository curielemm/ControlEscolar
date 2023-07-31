@extends('layouts.login')
<title>Inicio de Sesión</title>
@section('content')


<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card card-default border-dark">
            <div class="card-heading text-center">
                <h3 class="card-title">Inicio de Sesión Control Escolar</h3>
                <img class="img-fluid" alt="Responsive image" src="../img/usuario.jpg" alt="Card image cap">

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('loginI')}}">
                    {{csrf_field()}}
                    <div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" placeholder="ingresa tu email" value="{{old('email')}}">
                        {!! $errors->first('email','<span class="help-block text-danger">:message</span>') !!}
                    </div>
                    <div class="form-group  {{$errors->has('password') ? 'has-error':'' }}">
                        <label for="password">Contraseña</label>
                        <input class="form-control" type="password" name="password" placeholder="ingresa tu Contraseña">
                        {!! $errors->first('password','<span class="help-block text-danger">:message</span>') !!}
                    </div>
                    <button class="btn btn-primary btn-block">Acceder</button>
                </form>
                <div class="col-md-6 offset-md-4"> <a href="/registroUsuario">Registrarme</a>
                </div>
                <div class="col-md-10 offset-md-2"> <a href="{{ route('password.request')}}">¡Olvidé mi Contraseña!</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection