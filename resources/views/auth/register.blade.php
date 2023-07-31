@extends('layouts.login')
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Registro de Usuario</title>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro de Usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registroUsuario') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="clave_usuario" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                            <div class="col-md-6">
                                <input id="clave_usuario" type="text" class="form-control{{ $errors->has('clave_usuario') ? ' is-invalid' : '' }}" name="clave_usuario" value="{{ old('clave_usuario') }}" required autofocus>

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
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apaterno" class="col-md-4 col-form-label text-md-right">Apellido Paterno</label>

                            <div class="col-md-6">
                                <input id="apaterno" name="apaterno" type="text" class="form-control{{ $errors->has('apaterno') ? ' is-invalid' : '' }}" value="{{ old('apaterno') }}" required>
                                @if ($errors->has('apaterno'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('apaterno') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amaterno" class="col-md-4 col-form-label text-md-right">Apellido Materno</label>

                            <div class="col-md-6">
                                <input id="amaterno" name="amaterno" type="text" class="form-control{{ $errors->has('amaterno') ? ' is-invalid' : '' }}" value="{{ old('amaterno') }}" >
                                @if ($errors->has('amaterno'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amaterno') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="institucion" class="col-md-4 col-form-label text-md-right">Seleccione su Nivel</label>
                            <div class="col-md-6">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="2" id="optradio" name="optradio">Nivel Medio Superior
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="1" id="optradio" name="optradio">Nivel Superior
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="institucion" class="col-md-4 col-form-label text-md-right">Institución</label>

                            <div class="col-md-6">
                                <select class="form-control{{ $errors->has('institucion') ? ' is-invalid' : '' }}" id="institucion" name="institucion">

                                </select>
                                @if ($errors->has('institucion'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('institucion') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="puesto" class="col-md-4 col-form-label text-md-right">Puesto</label>

                            <div class="col-md-6">
                                <select class="form-control" id="puesto" name="puesto">
                                    @foreach($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6 offset-md-4"> <a href="/login">Prefiero Iniciar Sesion</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        //segundo AJAX
        // var fun = function() {
        $(function() {
            //funcion de select
            $(document).on('change', '#optradio', function() {
                //detectamos el evento change
                console.log("radio")
                var value = $(this).val(); //sacamos el valor del select
                var instituciones = $('#institucion');
                console.log(value);
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });
                $.ajax({

                    type: 'POST',

                    url: '/consultajax3',
                    //  async: false,

                    data: {
                        "valor": value
                    },

                    success: function(data) {

                        console.log(data);

                        instituciones.find('option').remove();

                        $(data).each(function(i, v) { // indice, valor
                            instituciones.append('<option value="' + v.clave_cct + '">' + v.nombre_institucion + '</option>');

                        })
                    }

                });
            });
        });
    </script>
    @endsection