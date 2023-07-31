@extends('layouts.app')
<title>Perfil</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Contraseña</a>
                    </li>



                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-header">{{ __('Mi Perfil') }}</div>
                        <a href="/panel" id="#{item.name}" class="fa fa-home" )>
                            Regresar al Panel Principal
                        </a>
                        <div class="card-body">
                            <form method="POST" action="{{ route('update',$datos->clave_usuario) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="clave_usuario" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                                    <div class="col-md-6">
                                        <input id="clave_usuario" value="{{$datos->clave_usuario}}" type="text" class="form-control{{ $errors->has('clave_usuario') ? ' is-invalid' : '' }}" name="clave_usuario" value="{{ old('clave_usuario') }}" required autofocus disabled>

                                        @if ($errors->has('clave_usuario'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('clave_usuario') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="nombre_usuario" name="nombre_usuario" type="text" value="{{$datos->nombre_usuario}}" class="form-control{{ $errors->has('nombre_usuario') ? ' is-invalid' : '' }}" value="{{ old('nombre_usuario') }}" required autofocus>

                                        @if ($errors->has('nombre_usuario'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre_usuario') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="apaterno" class="col-md-4 col-form-label text-md-right">Apellido Paterno</label>

                                    <div class="col-md-6">
                                        <input id="apellido_paterno" name="apellido_paterno" value="{{$datos->apellido_paterno}}" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" value="{{ old('apellido_paterno') }}" required>
                                        @if ($errors->has('apellido_paterno'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amaterno" class="col-md-4 col-form-label text-md-right">Apellido Materno</label>

                                    <div class="col-md-6">
                                        <input id="apellido_materno" name="apellido_materno" value="{{$datos->apellido_materno}}" type="text" class="form-control{{ $errors->has('apellido_materno') ? ' is-invalid' : '' }}" value="{{ old('apellido_materno') }}" required>
                                        @if ($errors->has('apellido_materno'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellido_materno') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" value="{{$datos->email}}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" disabled>

                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="institucion" class="col-md-4 col-form-label text-md-right">Institución</label>

                                    <div class="col-md-6">
                                        <input type="text" value="{{$datos->nombre_institucion}}" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="puesto" class="col-md-4 col-form-label text-md-right">Puesto</label>

                                    <div class="col-md-6">
                                        <input type="text" value="{{$datos->descripcion}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-header">{{ __('Cambiar Contraseña') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('updatePassword') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nueva Contraseña') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
