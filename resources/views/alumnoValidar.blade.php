@extends('layouts.app')
<title>Validar Alumno</title>
<script data-require="jquery@2.2.4" data-semver="2.2.4" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card">
            <div class="card-heading">
                <br>
                <center>
                    <h4> DATOS DEL ALUMNO(A) </h4>
                </center>
            </div>
            <div class="card-body">
                <form action="{{ route('validado')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">CURP:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" id="curp" name="curp" value="{{$alumno->curp}}">
                        </div>
                        <label class="col-sm-2 col-form-label">Matricula:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="15" id="matricula" name="matricula" value="{{$alumno->matricula}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="20" id="nombre" name="nombre" value="{{$alumno->nombre}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Apellido Paterno:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="20" id="apellido_paterno" name="apellido_paterno" value="{{$alumno->apellido_paterno}}">
                        </div>
                        <label class="col-sm-2 col-form-label">Apellido Materno:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="20" id="apellido_materno" name="apellido_materno" value="{{$alumno->apellido_materno}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sexo:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="9" id="genero" name="genero" value="@if($alumno->sexo=='H')Hombre @endif @if($alumno->sexo=='M')Mujer @endif">
                        </div>
                        <label class="col-sm-2 col-form-label">Correo:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" class="form-control" maxlength="35" id="correo" name="correo" value="{{$alumno->correo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Teléfono:</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" maxlength="10" class="form-control" id="telefono" name="telefono" value="{{$alumno->telefono}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Documentos Presentados:</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->acta_nacimiento == 1)
                                    <input type="checkbox" class="form-check-input" id="acta_nacimiento" name="acta_nacimiento" value="1" checked>Acta de Nacimiento
                                    @endif
                                    @if($alumno->acta_nacimiento != 1)
                                    <input type="checkbox" class="form-check-input" id="acta_nacimiento" name="acta_nacimiento" value="1">Acta de Nacimiento
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->curp_doc == 1)
                                    <input type="checkbox" class="form-check-input" id="curpt" name="curpt" value="1" checked>CURP
                                    @endif
                                    @if($alumno->curp_doc != 1)
                                    <input type="checkbox" class="form-check-input" id="curpt" name="curpt" value="1">CURP
                                    @endif
                                </label>
                            </div>
                            @if($nivel==3)
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->certificado_secundaria == 1)
                                    <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria" checked>Certificado Secundaria
                                    @endif
                                    @if($alumno->certificado_secundaria != 1)
                                    <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->certificado_bachillerato == 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_bachillerato" name="certificado_bachillerato" value="1" checked>Certificado Bachillerato
                                    @endif
                                    @if($alumno->certificado_bachillerato != 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_bachillerato" name="certificado_bachillerato" value="1">Certificado Bachillerato
                                    @endif
                                </label>
                            </div>
                            @endif
                            @if($nivel==4 or $nivel==5 )
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->certificado_lic == 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_lic" name="certificado_lic" value="1" checked>Certificado Licenciatura
                                    @endif
                                    @if($alumno->certificado_lic != 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_lic" name="certificado_lic" value="1">Certificado Licenciatura
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->titulo == 1)
                                    <input type="checkbox" class="form-check-input" id="titulo" name="titulo" value="1" checked>Titulo / Acta Examen Prof
                                    @endif
                                    @if($alumno->titulo != 1)
                                    <input type="checkbox" class="form-check-input" id="titulo" name="titulo" value="1">Titulo / Acta Examen Prof
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->cedula == 1)
                                    <input type="checkbox" class="form-check-input" id="cedula" name="cedula" value="1" checked>Cedula
                                    @endif
                                    @if($alumno->cedula != 1)
                                    <input type="checkbox" class="form-check-input" id="cedula" name="cedula" value="1">Cedula
                                    @endif
                                </label>
                            </div>
                            @endif
                            @if($nivel==6 )
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->certificado_ma == 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_ma" name="certificado_ma" value="1" checked>Certificado Maestria
                                    @endif
                                    @if($alumno->certificado_ma != 1)
                                    <input type="checkbox" class="form-check-input" id="certificado_ma" name="certificado_ma" value="1">Certificado Maestria
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->titulo_ma == 1)
                                    <input type="checkbox" class="form-check-input" id="titulo_ma" name="titulo_ma" value="1" checked>Titulo Maestria / Acta Examen Prof
                                    @endif
                                    @if($alumno->titulo_ma != 1)
                                    <input type="checkbox" class="form-check-input" id="titulo_ma" name="titulo_ma" value="1">Titulo Maestria / Acta Examen Prof
                                    @endif
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->cedula_ma == 1)
                                    <input type="checkbox" class="form-check-input" id="cedula_ma" name="cedula_ma" value="1" checked>Cedula
                                    @endif
                                    @if($alumno->cedula_ma != 1)
                                    <input type="checkbox" class="form-check-input" id="cedula_ma" name="cedula_ma" value="1">Cedula
                                    @endif
                                </label>
                            </div>
                            @endif
                            @if($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10)
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if($alumno->certificado_secundaria == 1)
                                    <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria" checked>Certificado Secundaria
                                    @endif
                                    @if($alumno->certificado_secundaria != 1)
                                    <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                                    @endif
                                </label>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observaciones:</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="rvoe" value="{{$rvoe}}" style="visibility:hidden">
                    <input type="hidden" name="clave_grupo" value="{{$clave_grupo}}" style="visibility:hidden">
                    <input type="hidden" class="form-control" value="{{$nivel}}" maxlength="15" id="nivel" name="nivel" style="visibility:hidden">
                    <input type="hidden" name="vigencia" id="vigencia" value="{{$vigencia}}">
                    <input type="hidden" name="clave_cct" id="clave_cct" value="{{$clave_cct}}">
                    <input type="hidden" name="observacionesT" id="observacionesT" value="0">
                    <center>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" name="validar" id="validar" class="btn btn-success">Validar</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" name="validar2" id="validar2" class="btn btn-success">Enviar Solo Observaciones</button>
                            </div>
                        </div>
                    </center>
                </form>



            </div>
            <center>
                <div class="col-sm-2" aling="left">
                    <form action="{{route('panel')}}" method="get">
                        <button type="submit" class=" btn btn-danger btn-block">Panel de Control </button>
                    </form>
                </div>
            </center>
        </div>

    </div>
    <script>
        /*$(':checkbox').on('click', function() {
        // para cada checkbox "chequeado"
        if ($(this).is(':checked')) {
            $("#validar").prop("disabled", false);
        } else {
            $("#validar").prop("disabled", true);
        }
    });*/
        var checked = 0;
        var Nochecked = 0;
        var total = 0;
        var nivel = $('#nivel');
        $(document).ready(function() {
            checked = $(":checkbox:checked").length; //Creamos una Variable y Obtenemos el Numero de Checkbox que esten Seleccionados
            Nochecked = $(":checkbox:not(:checked)").length;
            total = checked + Nochecked;
            if (nivel.val() == 3 && $('#certificado_secundaria').prop('checked') == false) {
                checked++;
            }
            if (checked == total) {
                $("#validar").prop("disabled", false);
                $("#matricula").prop("readonly", false);
            } else {
                $("#validar").prop("disabled", true);
                $("#matricula").prop("readonly", true);
            }
            //  
        });

        $(':checkbox').click(function() { //Creamos la Funcion del Click
            checked = $(":checkbox:checked").length; //Creamos una Variable y Obtenemos el Numero de Checkbox que esten Seleccionados
            Nochecked = $(":checkbox:not(:checked)").length;
            total = checked + Nochecked;
            /** 
             * Aqui debe de ir la validacion de la secundaria
             * && $('#certificado_secundaria:not(:checked)') comprobar porque no funcioan esto
             */
            if (nivel.val() == 3 && $('#certificado_secundaria').prop('checked') == false) {
                checked++;
            }
            if (checked == total) {
                $("#validar").prop("disabled", false);
                $("#matricula").prop("readonly", false);
            } else {
                $("#validar").prop("disabled", true);
                $("#matricula").prop("readonly", true);
            }
            //  
        });

        $('#validar2').click(function() {
            $('#observacionesT').val(1);
        });
    </script>
</div>
@endsection