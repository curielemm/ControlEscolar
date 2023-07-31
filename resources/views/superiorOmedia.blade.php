@extends('layouts.app')
<title>Superior o Media Superior</title>
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

            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card text-center" style="width: 15rem;">
                                <img class="card-img-top" src="../img/escuela.png" width="50" height="199" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Registrar Instituciones para Nivel Superior</p>
                                </div>
                                <a href="FormularioInstituciones2" class="btn btn-primary">Registro de Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card" style="width: 15rem;">
                                <img class="card-img-top" src="../img/escuela.png" width="60" height="199" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Registrar Instituciones para Nivel Medio Superior</p>
                                </div>
                                <a href="FormularioMSU" class="btn btn-success">Registro de Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card" style="width: 15rem;">
                                <img class="card-img-top" src="../img/escuela.png" width="60" height="175" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Registrar Instituciones para Capacitación para el Trabajo</p>
                                </div>
                                <a href="FormularioCPT" class="btn btn-success">Registro de Instituciones</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
