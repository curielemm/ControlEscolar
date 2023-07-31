@extends('layouts.app')
<title>Validar Inscripción</title>
<script data-require="jquery@2.2.4" data-semver="2.2.4" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<style>
    .my-custom-scrollbar {
        position: relative;
        height: 350px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    #divConta {
        max-width: 1400px;
    }
</style>

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">{{$institucion->nombre_institucion}}</h3>
            <h3 class="text-center">{{$datos->nombre_plan}} RVOE: {{$datos->rvoe}} Vigencia: {{$datos->vigencia}}</h3>
            <h4 class="text-center">LISTA DE ALUMNOS DEL GRUPO "{{$grupo->nombre_grupo}}" PARA VALIDAR </h4>
            <div class="card-header">

            </div>
            @if(session()->has('message2'))
            <div class="alert alert-success">
                {{ session()->get('message2') }}
            </div>
            @endif
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <div class="card-body">
                <div>
                    <form method="get" action="{{route('verGruposAnalista',[$datos->rvoe,$institucion->clave_cct,$datos->vigencia])}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Lista de Grupos</span>
                    </form>
                </div>
                @if($nivel == 3)
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>CURP</th>
                                <th>Matrícula</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Acta de Nacimiento</th>
                                <th>CURP</th>
                                <th>Certificado Secundaria</th>
                                <th>Certificado Bachillerato</th>
                                <th>Acciones</th>
                            </tr>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @if($alumno->status_inscripcion == 0) <tr class="table-warning">@endif
                                @if($alumno->status_inscripcion == 1)
                            <tr class="table-success">@endif
                                <form action="{{route('validarAlumno',[$alumno->curp,$rvoe,$datos->vigencia,$institucion->clave_cct])}}" method="get">
                                    {{csrf_field()}}
                                    <input type="hidden" name="nivel" value="{{$nivel}}" style="visibility:hidden">
                                    <input type="hidden" name="clave_grupo" value="{{$clave_grupo}}" style="visibility:hidden">
                                    <input type="hidden" name="rvoe" value="{{$rvoe}}" style="visibility:hidden">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alumno->curp}}</td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                    <td> @if($alumno->acta_nacimiento != 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled>@endif
                                        @if($alumno->acta_nacimiento == 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled checked>@endif</td>
                                    <td> @if($alumno->curp_doc != 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled>@endif
                                        @if($alumno->curp_doc == 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled checked>@endif</td>
                                    <td> @if($alumno->certificado_secundaria != 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled>@endif
                                        @if($alumno->certificado_secundaria == 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled checked>@endif</td>

                                    <td>@if($alumno->certificado_bachillerato != 1) <input type="checkbox" value="1" id="certificado_bachillerato" name="certificado_bachillerato" disabled>@endif
                                        @if($alumno->certificado_bachillerato == 1)<input type="checkbox" value="1" id="certificado_bachillerato" name="certificado_bachillerato" disabled checked>
                                        @endif</td>
                                    <td>
                                        <div>
                                            <button type="submit" class="btn btn-outline-success btn-block"><i class="fa fa-check-circle" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($nivel== 4 ||$nivel == 5 )
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>CURP</th>
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Acta de nacimiento</th>
                                <th>CURP</th>
                                <th>Certificado Licenciatura</th>
                                <th>Titulo / Acta Examen Prof.</th>
                                <th>Cedula Profesional</th>
                                <th>Acciones</th>
                            </tr>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @if($alumno->status_inscripcion == 0) <tr class="table-warning">@endif
                                @if($alumno->status_inscripcion == 1)
                            <tr class="table-success">@endif
                                <form action="{{route('validarAlumno',$alumno->curp)}}" method="get">
                                    <input type="text" name="nivel" value="{{$nivel}}" style="visibility:hidden">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alumno->curp}}</td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                    <td> @if($alumno->acta_nacimiento != 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled>@endif
                                        @if($alumno->acta_nacimiento == 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled checked>@endif</td>
                                    <td> @if($alumno->curp_doc != 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled>@endif
                                        @if($alumno->curp_doc == 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled checked>@endif</td>
                                    <td>@if($alumno->certificado_lic != 1)<input type="checkbox" value="1" id="certificado_lic" name="certificado_lic" disabled>@endif
                                        @if($alumno->certificado_lic == 1)<input type="checkbox" value="1" id="certificado_lic" name="certificado_lic" disabled checked>@endif</td>
                                    <td>@if($alumno->titulo != 1)<input type="checkbox" value="1" id="titulo" name="titulo" disabled>@endif
                                        @if($alumno->titulo == 1)<input type="checkbox" value="1" id="titulo" name="titulo" disabled checked>@endif</td>
                                    <td>@if($alumno->cedula != 1)<input type="checkbox" value="1" id="cedula" name="cedula" disabled>@endif
                                        @if($alumno->cedula == 1)<input type="checkbox" value="1" id="cedula" name="cedula" disabled checked>@endif</td>
                                    <td>
                                        <div>
                                            <button type="submit" class=" btn-danger btn-block" disabled>Validar</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($nivel == 6 )
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>CURP</th>
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Acta de nacimiento</th>
                                <th>CURP</th>
                                <th>Certificado de Maestria</th>
                                <th>Titulo de Maestria/ Acta de Examen Prof.</th>
                                <th>Cedula Profesional</th>
                                <th>Acciones</th>
                            </tr>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @if($alumno->status_inscripcion == 0) <tr class="table-warning">@endif
                                @if($alumno->status_inscripcion == 1)
                            <tr class="table-success">@endif
                                <form action="{{route('validarAlumno',$alumno->curp)}}" method="get">
                                    <input type="text" name="nivel" value="{{$nivel}}" style="visibility:hidden">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alumno->curp}}</td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                    <td> @if($alumno->acta_nacimiento != 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled>@endif
                                        @if($alumno->acta_nacimiento == 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled checked>@endif</td>
                                    <td> @if($alumno->curp_doc != 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled>@endif
                                        @if($alumno->curp_doc == 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled checked>@endif</td>
                                    <td>@if($alumno->certificado_ma != 1) <input type="checkbox" value="1" id="certificado_ma" name="certificado_ma" disabled> @endif
                                        @if($alumno->certificado_ma == 1) <input type="checkbox" value="1" id="certificado_ma" name="certificado_ma" disabled checked>@endif</td>
                                    <td>@if($alumno->titulo_ma != 1) <input type="checkbox" value="1" id="titulo_ma" name="titulo_ma">@endif
                                        @if($alumno->titulo_ma == 1) <input type="checkbox" value="1" id="titulo_ma" name="titulo_ma" disabled checked>@endif</td>
                                    <td> @if($alumno->cedula_ma != 1)<input type="checkbox" value="1" id="cedula_ma" name="cedula_ma" disabled>@endif
                                        @if($alumno->cedula_ma == 1)<input type="checkbox" value="1" id="cedula_ma" name="cedula_ma" disabled checked>@endif</td>
                                    <td>
                                        <div>
                                            <button type="submit" class=" btn-success btn-block" disabled>Validar</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @endif


                @if($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10 )
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>CURP</th>
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Acta de nacimiento</th>
                                <th>CURP</th>
                                <th>Certificado de Secundaria</th>
                                <th>Acciones</th>
                            </tr>
                        <tbody>
                            @foreach($alumnos as $alumno)

                            @if($alumno->status_inscripcion == 0) <tr class="table-warning">@endif
                                @if($alumno->status_inscripcion == 1)
                            <tr class="table-success">@endif
                                <form action="{{route('validarAlumno',$alumno->curp)}}" method="get">
                                    {{csrf_field()}}
                                    <input type="text" name="nivel" value="{{$nivel}}" style="visibility:hidden">
                                    <input type="text" name="rvoe" value="{{$rvoe}}" style="visibility:hidden">
                                    <input type="text" name="clave_grupo" value="{{$clave_grupo}}" style="visibility:hidden">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alumno->curp}} </td>
                                    <td>{{$alumno->matricula}}</td>
                                    <td>{{$alumno->nombre}}</td>
                                    <td>{{$alumno->apellido_paterno}}</td>
                                    <td>{{$alumno->apellido_materno}}</td>
                                    <td> @if($alumno->acta_nacimiento != 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled>@endif
                                        @if($alumno->acta_nacimiento == 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled checked>@endif</td>
                                    <td> @if($alumno->curp_doc != 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled>@endif
                                        @if($alumno->curp_doc == 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled checked>@endif</td>
                                    <td> @if($alumno->certificado_secundaria != 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled>@endif
                                        @if($alumno->certificado_secundaria == 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled checked>@endif</td>
                                    <td>
                                        <div>
                                            <button type="submit" id="validar" name="validar" class=" btn-success btn-block">Validar</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                </thead>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

<script type="text/javascript">
    /* $("form").submit(function() {
        $("input").removeAttr("disabled");
        $("input").hide();
    });


    $(':checkbox').on('click', function() {
        $("input[type=checkbox]:checked").each(function() {
            //cada elemento seleccionado
            console.log($(this).val())
            // alert();
        });
    });*/
</script>

@endsection