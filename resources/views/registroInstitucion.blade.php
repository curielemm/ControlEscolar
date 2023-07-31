@extends('layouts.app')
<title>Registro Institucion</title>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h2>Ingrese los datos de la Institución</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('registroIns')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Clave CCT:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" maxlength="30" placeholder="Ingrese la Clave CCT" name="clave_cct" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Nombre Institución:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el nombre de la Institución" name="nombre" required pattern="[A-Za-z ñ]+">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Reglamento:</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" maxlength="10" placeholder="Adjunte el reglamento" name="reglamento" required pattern="[A-Za-z ñ]+">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Plan de Estudios:</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" minlength="10" maxlength="11" placeholder="Adjunte su plan de Estudios" name="plan_estudio" required pattern="[0-9]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Numero de inscripción:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" minlength="10" maxlength="11" placeholder="ingrese el numero de Inscripción" name="no_inscripcion" required pattern="[0-9]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2">Fecha de Inscripción:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" minlength="10" maxlength="11" name="fecha_inscripcion" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <a href="CarrerasDinamico"><button type="submit" class="btn btn-primary btn-block">Siguiente</button></a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection