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
        table-layout: fixed;
        width: 250px;
    }

    th,
    td {

        width: 120px;
        word-wrap: break-word;
    }


    #calificaciones {
        width: 99%;
    }

    #fechas {
        width: 100%;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 410px;
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

            <h3 class="text-center"> Datos de Alumno: {{$alumno->curp }} {{$alumno->matricula}} {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno}}</h3>
            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
            <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$clave_grupo}}">
            <input type="hidden" id="parciales" name="parciales" value="">
            <div class="card-body">
                <h4 class="text-center">Agregue las calificaciones correspondientes</h4>
                @if($alumno->status_inscripcion == 0) <h4 class="text-center text-danger">*ALUMNO NO INSCRITO*</h4>@endif
            </div>
            <div class="card-body">
                <form id="calif">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <div id="tabla" name="tabla">
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h4 class="text-center">Agregue las fechas correspondientes de acuerdo a su calendario escolar</h4>
                    </div>
                    <hr>
                    <div id="tablita" name="tablita">
                    </div>
                    <div>
                        <input type="hidden" id="array" name="array" value="">
                        <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary">Cargar Calificaciones</button>
                    </div>
                </form>
                <center>
                    <div class="col-sm-offset-0 col-sm-10">
                        <form action="{{route('panel')}}" method="get">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-success">Panel de Control</button>
                        </form>
                    </div>
                </center>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {

        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var curp = $('#curp').val();
        var clave_grupo = $('#clave_grupo').val();
        var parcial = $('#parciales');
        console.log('rvoe: ' + rvoe);
        console.log('vigencia: ' + vigencia);
        var datos;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/matAluGgpAsig',
            data: {
                "rvoe": rvoe,
                "vigencia": vigencia,
                'curp': curp,
                'clave_grupo': clave_grupo
            },
            success: function(datas) {
                console.log("tamaño " + datas.length);
                if (datas.length > 1) {
                    asignaturas = datas[0];
                    arrno_parciales = datas[1];
                    var doce = datas[2];
                    var obse = datas[3];
                    var no_parciales = arrno_parciales['no_parciales']
                    var body = document.getElementById("tabla");
                    var tabla = document.createElement("table");
                    var thead = document.createElement("thead");
                    var tblBody = document.createElement("tbody");
                    var hilerah = document.createElement("tr");
                    var columnas = 8 + no_parciales;
                    var filas = asignaturas.length;
                    var valor = 0;
                    parcial.val(no_parciales);
                    for (var i = 0; i < columnas; i++) {
                        valor = i + 1 - 2;
                        var celdath = document.createElement("th");
                        if (i == 0) {
                            var textoCeldath = document.createTextNode("Clave Asg");
                        } else if (i == 1) {
                            var textoCeldath = document.createTextNode("Nombre Asg");
                        } else if (i == columnas - 1) {
                            var textoCeldath = document.createTextNode("Obs.");
                        } else if (i == columnas - 2) {
                            var textoCeldath = document.createTextNode("Docente");
                        } else if (i == columnas - 3) {
                            var textoCeldath = document.createTextNode("% Asistencia");
                        } else if (i == columnas - 4) {
                            var textoCeldath = document.createTextNode("Calificación");
                        } else if (i == columnas - 5) {
                            var textoCeldath = document.createTextNode("Prom. Final");
                        } else if (i == columnas - 6) {
                            var textoCeldath = document.createTextNode("Ordinario");
                        } else {
                            var textoCeldath = document.createTextNode("Parcial    " + valor + "  ");
                        }
                        celdath.appendChild(textoCeldath);
                        hilerah.appendChild(celdath);
                    }
                    thead.appendChild(hilerah);
                    for (var i = 0; i < filas; i++) {
                        var hilera = document.createElement("tr");
                        for (var j = 0; j < columnas; j++) {
                            // Crea un elemento <td> y un nodo de texto, haz que el nodo de
                            // texto sea el contenido de <td>, ubica el elemento <td> al final
                            // de la hilera de la tabla
                            var celda = document.createElement("td");

                            if (no_parciales == 5) {
                                if (j == 6) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl5"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 5) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl4"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 4) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl3"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 3) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl2"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 2) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl1"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 0) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                } else if (j == 1) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                } else if (j == 11) {
                                    var x = document.createElement("select");
                                    for (var f = 0; f < doce.length; f++) {
                                        let option1 = document.createElement("option");
                                        option1.setAttribute("value", "value1");
                                        let option1Texto = document.createTextNode("opcion 1");
                                        option1.appendChild(option1Texto);
                                        x.appendChild(option1);
                                    }
                                    var textoCelda = x;
                                } else if (j == 10) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["porcentaje_asistencia"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 9) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["promedio_final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 8) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 7) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["ordinario"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                }
                            } else if (no_parciales == 4) {
                                if (j == 5) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl4"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 4) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl3"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 3) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl2"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 2) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl1"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 0) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                } else if (j == 1) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                } else if (j == 11) {
                                    var x = document.createElement("select");
                                    for (var f = 0; f < obse.length; f++) {
                                        var option1 = document.createElement("option");
                                        option1.setAttribute("value", obse[f]["id_observaciones"]);
                                        var option1Texto = document.createTextNode(obse[f]["nombre_observaciones"]);
                                        option1.appendChild(option1Texto);
                                        x.setAttribute("name", "select2");
                                        x.setAttribute("id", i + 10);
                                        x.appendChild(option1);
                                    }
                                    x.setAttribute("class", "form-control");
                                    var textoCelda = x;
                                } else if (j == 10) {
                                    var x = document.createElement("select");
                                    for (var f = 0; f < doce.length; f++) {
                                        var option1 = document.createElement("option");
                                        option1.setAttribute("value", doce[f]["rfc"]);
                                        var option1Texto = document.createTextNode(doce[f]["nombre"] + " " + doce[f]["apellido_paterno"] + " " + doce[f]["apellido_materno"]);
                                        option1.appendChild(option1Texto);
                                        x.setAttribute("name", "select");
                                        x.setAttribute("id", i);
                                        x.appendChild(option1);
                                    }
                                    x.setAttribute("class", "form-control");
                                    var textoCelda = x;
                                } else if (j == 9) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["porcentaje_asistencia"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 8) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["promedio_final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 7) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 6) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["ordinario"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                }

                            } else if (no_parciales == 3) {
                                if (j == 4) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl3"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 3) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl2"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 2) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl1"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 0) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                } else if (j == 1) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                } else if (j == 8) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["porcentaje_asistencia"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 7) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["promedio_final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 6) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 5) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["ordinario"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                }

                            } else if (no_parciales == 2) {
                                if (j == 3) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl2"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 2) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl1"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 0) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                } else if (j == 1) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                } else if (j == 7) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["porcentaje_asistencia"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 6) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["promedio_final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 5) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 4) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["ordinario"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                }
                            } else if (no_parciales == 1) {
                                if (j == 2) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["pl1"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 0) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                } else if (j == 1) {
                                    var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                } else if (j == 6) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["porcentaje_asistencia"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 5) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["promedio_final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 4) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["final"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                } else if (j == 3) {
                                    var x = document.createElement("input");
                                    x.setAttribute("type", "number");
                                    x.setAttribute("class", "form-control");
                                    x.setAttribute("required", "");
                                    x.setAttribute("step", "0.01");
                                    x.setAttribute("value", asignaturas[i]["ordinario"]);
                                    x.setAttribute("min", "0");
                                    var textoCelda = x;
                                }
                            }
                            /*var x = document.createElement("input");
                            x.setAttribute("type", "number");
                            x.setAttribute("class", "form-control");
                            x.setAttribute("required", "");
                            x.setAttribute("step", "0.01");
                            x.setAttribute("value", "");
                            x.setAttribute("min", "0");
                            var textoCelda = x;*/


                            celda.appendChild(textoCelda);
                            hilera.appendChild(celda);
                        }
                        // agrega la hilera al final de la tabla (al final del elemento tblbody)
                        tblBody.appendChild(hilera);
                    }
                    tabla.className += "table  table-bordered";
                    tabla.setAttribute("id", "calificaciones")
                    tabla.appendChild(thead);
                    tabla.appendChild(tblBody);
                    body.appendChild(tabla);

                    var numeroDatos = no_parciales + 1;
                    //aqui creamos la tabla para las fechas;
                    var date1 = document.getElementById("tablita");
                    var dataTabla = document.createElement("table");
                    var theadDate = document.createElement("thead");
                    var thileraDate = document.createElement("tr");
                    var dateBody = document.createElement("tbody");
                    var valor2 = 0;
                    for (var d = 0; d < numeroDatos; d++) {
                        valor2 = d + 1;
                        var celdathd = document.createElement("th");

                        if (d == numeroDatos - 1) {
                            var textoCeldathd = document.createTextNode("Fecha Ordinario");
                        } else {
                            var textoCeldathd = document.createTextNode("Fecha Parcial  " + valor2);
                        }
                        celdathd.appendChild(textoCeldathd);
                        thileraDate.appendChild(celdathd);
                    }
                    theadDate.appendChild(thileraDate);
                    for (var a = 0; a < 1; a++) {
                        var dateHilera = document.createElement("tr");
                        for (var b = 0; b < numeroDatos; b++) {

                            var celdaDate = document.createElement("td");
                            var x = document.createElement("input");
                            x.setAttribute("type", "date");
                            x.setAttribute("class", "form-control");
                            x.setAttribute("required", "");
                            x.setAttribute("min", "0");
                            var textoCeldaDate = x;
                            celdaDate.appendChild(textoCeldaDate);
                            dateHilera.appendChild(celdaDate);
                        }
                        dateBody.appendChild(dateHilera);
                    }
                    dataTabla.className += "table table-bordered";
                    dataTabla.setAttribute("id", "fechas")
                    dataTabla.appendChild(theadDate);
                    dataTabla.appendChild(dateBody);
                    date1.appendChild(dataTabla);
                } else {
                    var anuncio = document.getElementById("tabla");
                    var anuncio2 = document.createElement("h4")
                    var anuncio3 = document.createTextNode("No hay registros")
                    anuncio2.appendChild(anuncio3);
                    anuncio2.setAttribute("class","text-center")
                    anuncio.appendChild(anuncio2);
                    boton = $('#cargar');
                    boton.prop('disabled', true);
                }
            }

        });
    });
</script>

<script>
    $(document).on('submit', '#calif', function() {
        event.preventDefault();
        var input = $("#array");
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var curp = $('#curp').val();
        var clave_grupo = $('#clave_grupo').val();
        var parciales = $('#parciales').val();
        var myTableArray = [];
        var myTableArray2 = [];
        var sele = $("select");
        var incremento = 0;
        var incremento2 = 10;
        //console.log(sele);
        $("table#calificaciones tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() {
                    if ($(this).find("select").length > 0) {
                        console.log($(this).find("select").length);
                        var select = $(this).find("select");
                        arrayOfThisRow.push(($("#" + incremento + " option:selected").val()));
                        arrayOfThisRow.push(($("#" + incremento2 + " option:selected").val()));
                        //console.log("este es el incremento " + incremento);
                    } else if ($(this).text() == "") {
                        // if ($(this).find("input").length > 0) {
                        var input = $(this).find("input");
                        // console.log("soy un input");
                        arrayOfThisRow.push(input.val());
                        /* else if ($(this).find("select").length > 0) {
                            console.log("soy un select")
                            arrayOfThisRow.push(($("select option:selected").val()));
                        }*/
                    } else {
                        arrayOfThisRow.push($(this).text());
                    }
                });
                myTableArray.push(arrayOfThisRow);
                incremento = incremento + 1;
                incremento2 = incremento2 + 1;
            }
        });

        $("table#fechas tr").each(function() {
            var arrayOfThisRow2 = [];
            var tableData2 = $(this).find('td');
            if (tableData2.length > 0) {
                tableData2.each(function() {
                    if ($(this).text() == "") {
                        var input = $(this).find("input")
                        arrayOfThisRow2.push(input.val());
                    } else {
                        arrayOfThisRow2.push($(this).text());
                    }
                });
                myTableArray2.push(arrayOfThisRow2);
            }
        });
        //  console.log(myTableArray2);
        console.log(myTableArray);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/sendArray',
            data: {
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'curp': curp,
                'clave_grupo': clave_grupo,
                'parciales': parciales,
                'array2': myTableArray2,
            },
            success: function(datas) {
                window.location = datas.link;
                console.log(datas);
            }
        });
        //input.val(myTableArray);
        //  event.currentTarget.submit();
    });
</script>

@endsection