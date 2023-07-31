@extends('layouts.app')
<title>Ver Instituciones</title>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="card">
            <div>
                <form method="get" action="{{'/panel'}}">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                </form>
            </div>
            <div class="card-header">{{ __('Elija una Opción') }}</div>
            @if(session()->has('message2'))
                <div class="alert alert-danger">
                    {{ session()->get('message2') }}
                </div>
                @endif
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card text-center" style="width: 15rem;">
                                <img class="card-img-top" src="../img/42.png" width="50" height="200" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Ver Instituciones</p>
                                </div>
                                <a href="listarInstitucion" class="btn btn-primary">Ver Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card" style="width: 15rem;">
                                <img class="card-img-top" src="../img/42.png" width="60" height="175" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Ver Instituciones de Nivel Medio Superior</p>
                                </div>
                                <a href="listarInstitucionMSU" class="btn btn-primary">Ver Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card" style="width: 15rem;">
                                <img class="card-img-top" src="../img/42.png" width="60" height="150" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Ver Instituciones de Capacitación para el Trabajo</p>
                                </div>
                                <a href="listarInstitucionCPT" class="btn btn-primary">Ver Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
