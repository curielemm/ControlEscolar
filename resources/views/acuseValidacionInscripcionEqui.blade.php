<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acuse de Validación de Inscripción Equivalencias</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style type="text/css">
        @page {
            margin: 0cm 0cm;
            font-size: 2.5mm;
        }

        body {
            margin: 2cm 2cm 2cm;
        }

        #qr {
            position: fixed;
            top: 3.5cm;
            left: 24cm;
            right: 0cm;
        }

        #header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            background-color: white;
            color: black;
            text-align: center;
            line-height: 30px;

        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            background-color: white;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        #content {
            position: fixed;
        }

        #content img {
            position: fixed;
            top: 0px;
            right: 900px;

        }

        #divder {
            position: absolute;
            top: 2.5cm;
            left: 0cm;
            right: 0cm;
            column-count: 2;
            column-gap: 400px;

        }

        table {
            position: relative;
            top: 5.5cm;
            left: 0cm;
            right: 1cm;
        }

        #tablita {}

        #divizq {
            position: absolute;
            top: 2.5cm;
            left: 16cm;
            right: 0cm;
            column-count: 2;
            column-gap: 400px;
        }
    </style>

</head>

<body>
    <header id="header">

        <div id="content">
            <img src="{{ public_path('img\logocg.png') }}" width="200" height="50">
        </div>
        <h4 class="text-center">Coordinación General de Educación Media Superior, Superior, Ciencia y Tecnologia</h4>
        <h4 class="text-center">{{$institucion->nombre_institucion}}</h4>
        <h4 class="text-center">{{$plan->nombre_plan}}</h4>
        <h4 class="text-center">RVOE: {{$plan->rvoe}} Vigencia: {{$plan->vigencia}}</h4>
        <h4 class="text-center">Acuse de Validación de Inscripción Con Equivalencias</h4>

    </header>
    <div id="qr"> <img src="data:image/png;base64,{{ base64_encode($codigoQR) }}"></div>
    <div id="divder">
        <div>
            <h4> Grupo: {{$grupo->no_periodo}}° {{$grupo->nombre_grupo}} </h4>
        </div>
        <div>
            <h4> Periodo Escolar: {{$grupo->fecha_ini}} al {{$grupo->fecha_fin}} </h4>
        </div>
    </div>

    <div id="divizq">
        <div>
            <h4> Ciclo Escolar: {{$grupo->fk_clave_ciclo_escolar}} </h4>
        </div>
        <div>
            <h4>Turno: {{$grupo->nombre_turno}} </h4>
        </div>

    </div>


    <!--div id="tablita"-->

    @if($nivel == 3)
    <table class="table table-striped" style="page-break-after:auto;">
        <thead>
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
                <th>Certificado Parcial</th>
                <th>Equivalencia</th>
                <th>Folio de Equivalencia</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$alumno->curp}}</td>
                <td>{{$alumno->matricula}}</td>
                <td>{{$alumno->nombre}}</td>
                <td>{{$alumno->apellido_paterno}}</td>
                <td>{{$alumno->apellido_materno}}</td>
                <td> @if($alumno->acta_nacimiento != 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled>@endif
                    @if($alumno->acta_nacimiento == 1) <input type="checkbox" value=1 id="acta_nacimiento" name="acta_nacimiento" disabled checked>@endif
                </td>
                <td> @if($alumno->curp_doc != 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled>@endif
                    @if($alumno->curp_doc == 1)<input type="checkbox" value=1 id="curpt" name="curpt" disabled checked>@endif
                </td>
                <td> @if($alumno->certificado_secundaria != 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled>@endif
                    @if($alumno->certificado_secundaria == 1)<input type="checkbox" value="1" id="certificado_secundaria" name="certificado_secundaria" disabled checked>@endif
                </td>

                <td>@if($alumno->certificado_bachillerato != 1) <input type="checkbox" value="1" id="certificado_bachillerato" name="certificado_bachillerato" disabled>@endif
                    @if($alumno->certificado_bachillerato == 1)<input type="checkbox" value="1" id="certificado_bachillerato" name="certificado_bachillerato" disabled checked>
                    @endif
                </td>
                <td>@if($alumno->certificado_parcial != 1) <input type="checkbox" value="1" id="certificado_parcial" name="certificado_parcial" disabled>@endif
                    @if($alumno->certificado_parcial == 1)<input type="checkbox" value="1" id="certificado_parcial" name="certificado_parcial" disabled checked>
                    @endif</td>
                <td>@if($alumno->equivalencia != 1) <input type="checkbox" value="1" id="equivalencia" name="equivalencia" disabled>@endif
                    @if($alumno->equivalencia == 1)<input type="checkbox" value="1" id="equivalencia" name="equivalencia" disabled checked>
                    @endif</td>
                <td>{{$alumno->folio_equivalencia}}</td>
                <td>{{$alumno->observaciones}}</td>
            </tr>

            @endforeach

        </tbody>
    </table>
    @endif

    @if($nivel== 4 ||$nivel == 5 )
    <table class="table table-striped">
        <thead>
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
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)

            <tr>
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
                <td>{{$alumno->observaciones}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($nivel == 6 )
    <table class="table table-striped">
        <thead>
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
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)

            <tr>
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
                <td>{{$alumno->observaciones}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
    @endif


    @if($nivel == 1 or $nivel == 2 or $nivel == 7 or $nivel == 8 or $nivel == 9 or $nivel == 10 )
    <table class="table table-striped ">
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
                <th>Observaciones</th>
            </tr>
        <tbody>
            @foreach($alumnos as $alumno)


            <tr>

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

                <td>{{$alumno->observaciones}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <!--/div-->

    <footer>
        <p>{{ auth()->user()->nombre_usuario}} {{ auth()->user()->apellido_paterno}} {{ auth()->user()->apellido_materno}} </p>
        ___________________________________
    </footer>
</body>

</html>