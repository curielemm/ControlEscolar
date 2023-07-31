<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acuse de Validación de Inscripción</title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        @page {
            margin: 0cm 0cm;
            font-size: 2.0mm;
        }

        body {
            margin: 2cm 2cm 2cm;
        }

        #qr {
            position: fixed;
            top: 2.5cm;
            left: 21.5cm;
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


        #content {
            position: fixed;
        }

        #content img {
            position: fixed;
            top: 0px;
            right: 900px;

        }

        #divder {
            position: fixed;
            top: 2.2cm;
            left: 0.8cm;
            right: 0cm;
            column-count: 2;
            column-gap: 400px;

        }

        #table {
            position: relative;
            top: 3.5cm;
            left: 0cm;
            right: 1cm;
            height: 10px;
        }

        #table2 {
            position: relative;
            top: 3.5cm;
            left: 0cm;
            right: 1cm;
            height: 50px;
        }

        #table3 {
            position: relative;
            top: 3.5cm;
            left: 0cm;
            right: 1cm;
            height: 50px;
        }

        #divizq {
            position: fixed;
            top: 2.2cm;
            left: 25cm;
            right: 0cm;
            column-count: 2;
            column-gap: 400px;
        }

        #center {
            position: fixed;
            bottom: 15cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: white;
            color: black;
            text-align: center;
        }

        #center2 {
            position: fixed;
            top: 19.2cm;
            text-align: center;
        }

        #center3 {
            position: fixed;
            top: 14.2cm;
            right: 3cm;
            text-align: center;
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
        <h4 class="text-center">Acuse de Validación de Acreditación</h4>
    </header>
    <div id="qr">
        <img src="data:image/png;base64,{{ base64_encode($codigoQR) }}">
    </div>
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
    @for ($i = 0; $i < sizeof($asignaturas); $i++) <div id="center">
        <h4>{{$asignaturas[$i]->nombre_asignatura}}</h4>
        </div>
        <div id="center2">
            <h6>{{auth()->user()->nombre_usuario}} {{ auth()->user()->apellido_paterno}} {{ auth()->user()->apellido_materno}}</h6>
            <h6>_______________________________</h6>
        </div>
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CURP</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Parcial 3</th>
                    <th>Parcial 4</th>
                    <th>Ordinario</th>
                    <th>Prom. Final</th>
                    <th>Calif. Final</th>
                    <th>% Asistencia</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @for ($j = 0; $j < sizeof($array[$i]); $j++)<tr>
                    <td>{{$j+1}}
                    </td>
                    <td>{{$array[$i][$j]->curp}}</td>
                    <td>{{$array[$i][$j]->matricula}}</td>
                    <td>{{$array[$i][$j]->nombre}}</td>
                    <td>{{$array[$i][$j]->apellido_paterno}}</td>
                    <td>{{$array[$i][$j]->apellido_materno}}</td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0)
                        -
                        @endif
                        @if($array[$i][$j]->status_inscripcion == 1)
                        {{$array[$i][$j]->pl1}}
                        @endif
                    </td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0) - @endif
                        @if($array[$i][$j]->status_inscripcion == 1) {{$array[$i][$j]->pl2}} @endif</td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0) - @endif
                        @if($array[$i][$j]->status_inscripcion == 1) {{$array[$i][$j]->pl3}} @endif</td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0)
                        -
                        @endif
                        @if($array[$i][$j]->status_inscripcion == 1)
                        {{$array[$i][$j]->pl4}}
                        @endif
                    </td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0)
                        -
                        @endif
                        @if($array[$i][$j]->status_inscripcion == 1)
                        {{$array[$i][$j]->ordinario}}
                        @endif
                    </td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0)
                        -
                        @endif
                        @if($array[$i][$j]->status_inscripcion == 1)
                        {{$array[$i][$j]->final}}
                        @endif
                    </td>
                    <td>@if($array[$i][$j]->status_inscripcion == 0)
                        -
                        @endif
                        @if($array[$i][$j]->status_inscripcion == 1)
                        {{$array[$i][$j]->promedio_final}}
                        @endif
                    </td>
                    <td>{{$array[$i][$j]->porcentaje_asistencia}}</td>
                    <td>{{$array[$i][$j]->nombre_observaciones}}</td>
                    </tr>
                    @endfor
            </tbody>
        </table>
        <table id="table2" class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha Parcial 1</th>
                    <th>Fecha Parcial 2</th>
                    <th>Fecha Parcial 3</th>
                    <th>Fecha Parcial 4</th>
                    <th>Fecha Examen Ordinario </th>
                </tr>
            </thead>
            <tbody>
                @for($k = 0; $k < 1; $k++) <tr>
                    <td>{{$array[$i][$k]->fpl1}}</td>
                    <td>{{$array[$i][$k]->fpl2}}</td>
                    <td>{{$array[$i][$k]->fpl3}}</td>
                    <td>{{$array[$i][$k]->fpl4}}</td>
                    <td>{{$array[$i][$k]->fordinario}}</td>
                    </tr>
                    @endfor
            </tbody>
        </table>

        @if($i== sizeof($asignaturas)-1) <table id="table3" class="table table-striped">@endif
            @if($i<  sizeof($asignaturas)-1) <table id="table3" class="table table-striped" style="page-break-after: always;">@endif
                <thead>
                    <tr>
                        <th>Datos del Docente /
                            Nombre </th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                    </tr>
                </thead>
                <tbody>
                    @for($k = 0; $k < 1; $k++) <tr>
                        <td>{{$array[$i][$k]->ndocente}}</td>
                        <td>{{$array[$i][$k]->nap}}</td>
                        <td>{{$array[$i][$k]->nam}}</td>
                        </tr>
                        @endfor
                </tbody>
        </table>
        @endfor

</body>

</html>