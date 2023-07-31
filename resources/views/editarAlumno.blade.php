@extends('layouts.app')
<title>Editar Alumno</title>
@section('content')

<div class="row">
    <div class="col-md-11 offset-md-12">
        <div class="card card-default">
            <div class="card-heading">
                <br>
                <center>
                    <h4>ACTUALICE LOS DATOS DEL ALUMNO(A)</h4>
                    <center>
            </div>
            <div class="card-body">
                <form action="{{ route('editarAlum',$uno->curp)}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">CURP:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="curp" name="curp" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->curp}}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Matricula:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="15" id="matricula" name="matricula" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->matricula}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="20" id="nombre" name="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->nombre}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Apellido Paterno:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="20" id="apellido_paterno" name="apellido_paterno" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->apellido_paterno}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Apellido Materno:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="20" id="apellido_materno" name="apellido_materno" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->apellido_materno}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sexo:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="9" id="genero" name="genero" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->sexo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Correo:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="35" id="correo" name="correo" value="{{$uno->correo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Teléfono:</label>
                        <div class="col-sm-8">
                            <input type="number" maxlength="10" class="form-control" id="telefono" name="telefono" value="{{$uno->telefono}}">
                        </div>
                    </div>
                    <input type="text" class="form-control" value="{{$clave_grupo}}" maxlength="15" name="clave_grupo" style="visibility:hidden">

            </div>

            <tr>
                <center>
                    <div class="col-sm-10">
                        <form action="" method="get">
                            <button type="submit" class=" btn btn-success">Actualizar Datos</button>
                    </div>
                </center>

                </form>

                <div class="col-sm-2" aling="left">
                    <form action="" method="get">
                        <button type="submit" class=" btn btn-danger btn-block">Regresar </button>
                    </form>
                </div>
                </center>


        </div>

    </div>
</div>

@endsection
