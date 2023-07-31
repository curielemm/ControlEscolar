@extends('layouts.app')
<title>Registro Plan de Estudios</title>
@section('content')

<div class="container" >
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h2>Ingrese los datos del Plan de Estudios</h2>
            </div>

            <div class="card-body" >
                <form  action="{{ route('insertarPlan')}}" method="post"  >
                {{csrf_field()}}
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Clave de Plan:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="30" placeholder="Ingrese la Clave del Plan de Estudios" name="clave_plan" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Numero de Revoe:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="13" placeholder="Ingrese el numero de revoe" name="revoe" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Nombre del Plan:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el nombre del Plan de Estudios" name="nombre_plan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Vigencia:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="30" placeholder="Ingrese la vigencia del plan de estudios" name="vigencia" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Numero de Creditos:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" minlength="10" maxlength="11" placeholder="ingrese el numero de creditos" name="no_creditos" required pattern="[0-9]">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Duración de Ciclo:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="30" placeholder="ingrese la duración del ciclo" name="duracion_ciclo" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Descripción:</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" id="descripcion" name='descripción' rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                    </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
