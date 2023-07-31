@extends('layouts.app')
<title> Asignaturas del Alumno</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    table {
        width: 150px;
    }

    th,
    td {

        width: 180px;
        word-wrap: break-word;
    }


    #calificaciones {
        width: 78%;
    }



    #calificaciones {
        width: 99%;
    }

    #fechas {
        width: 100%;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 510px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    #divConta {
        max-width: 1400px;
    }
</style>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Plan de Estudios del RVOE: {{$plan->rvoe}} Vigencia: {{$plan->vigencia}} </h3>
            <h3 class="text-center">Grupo: {{$grupo->nombre_grupo}} Periodo Escolar {{$grupo->fecha_ini}} al {{$grupo->fecha_fin}}</h3>

            <h3 class="text-center"> Datos de Alumno: CURP: {{$alumno->curp }} Matricula: {{$alumno->matricula}} {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno}}</h3>
            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
            <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">
            <input type="hidden" id="parciales" name="parciales" value="">
            <div class="card-body">
                <h4 class="text-center">Calificaciones de las Asignaturas Aprobadas en Periodo Extraordinario</h4>
            </div>
            <div class="card-body">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clave Asignatura</th>
                                    <th>Nombre Asignatura</th>
                                    <th>Calificación</th>
                                    <th>Fecha de Aplicación</th>
                                    <th>Observaciones</th>
                                    <th>Nombre Docente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos as $dato)
                                <tr>
                                    <td>{{$loop->iteration}} </td>
                                    <td>{{$dato->clave_asignatura}} </td>
                                    <td>{{$dato->nombre_asignatura}} </td>
                                    <td>{{$dato->calificacion}} </td>
                                    <td>{{$dato->fecha_aplicacion}} </td>
                                    <td>{{$dato->nombre_observaciones}} </td>
                                    <td>{{$dato->nombre}} {{$dato->apellido_paterno}} {{$dato->apellido_materno}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <hr>
                  
            </div>
        </div>
    </div>

</div>

@endsection