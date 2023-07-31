@extends('layouts.app')
<title>Calificacion de Examenes Extraordinarios</title>
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
        height: 210px;
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
            <h3 class="text-center"> Datos de Alumno: {{$alumno->curp }} {{$alumno->matricula}} {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno}}</h3>
            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
            <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$clave_grupo}}">
            <div class="card-body">
                <h4 class="text-center">Lista de Asignaturas No Aprobadas en el Período Ordinario</h4>
            </div>
            <div class="card-body">
                <form id="calif">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <div id="tabla" name="tabla">
                        </div>
                    </div>
                    <hr>
                    <div>
                        <input type="hidden" id="array" name="array" value="">
                        <button type="submit" id="cargar" name="cargar" class="btn btn-primary">Enviar Datos</button>
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
            url: '/materiasNoOrdinario',
            data: {
                "rvoe": rvoe,
                "vigencia": vigencia,
                'curp': curp,
                'clave_grupo': clave_grupo
            },
            success: function(datas) {
                console.log(datas);
                asignaturas = datas[0];
                docente = datas[1];
                var body = document.getElementById("tabla");
                var tabla = document.createElement("table");
                var thead = document.createElement("thead");
                var tblBody = document.createElement("tbody");
                var hilerah = document.createElement("tr");
                var columnas = 6;
                var filas = asignaturas.length;
                var valor = 0;
                for (var i = 0; i < columnas; i++) {
                    var celdath = document.createElement("th");
                    if (i == 0) {
                        var textoCeldath = document.createTextNode("Clave Asg");
                    } else if (i == 1) {
                        var textoCeldath = document.createTextNode("Nombre Asg");
                    } else if (i == 5) {
                        var textoCeldath = document.createTextNode("Obs.");
                    } else if (i == 4) {
                        var textoCeldath = document.createTextNode("Docente");
                    } else if (i == 3) {
                        var textoCeldath = document.createTextNode("Fecha de Aplicación");
                    } else if (i == 2) {
                        var textoCeldath = document.createTextNode("Calificación");
                    }
                    celdath.appendChild(textoCeldath);
                    hilerah.appendChild(celdath);
                }
                thead.appendChild(hilerah);
                for (var i = 0; i < filas; i++) {
                    var hilera = document.createElement("tr");
                    for (var j = 0; j < columnas; j++) {
                        var celda = document.createElement("td");
                        if (j == 0) {
                            var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                        } else if (j == 1) {
                            var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                        } else if (j == 2) {
                            var x = document.createElement("input");
                            x.setAttribute("type", "number");
                            x.setAttribute("class", "form-control");
                            x.setAttribute("required", "");
                            x.setAttribute("readonly", "");
                            x.setAttribute("value", asignaturas[i]["promedio_final"]);
                            var textoCelda = x;
                        } else if (j == 3) {
                            var x = document.createElement("input");
                            x.setAttribute("type", "date");
                            x.setAttribute("class", "form-control");
                            x.setAttribute("required", "");
                            var textoCelda = x;
                        } else if (j == 4) {
                            var x = document.createElement("select");
                            var option1 = document.createElement("option");
                            option1.setAttribute("value", asignaturas[i]["rfc_docente"]);
                            var option1Texto = document.createTextNode(asignaturas[i]["nombre"] + " " + asignaturas[i]["apellido_paterno"] + " " + asignaturas[i]["apellido_materno"]);
                            option1.appendChild(option1Texto);
                            x.setAttribute("name", "select");
                            x.setAttribute("id", i);
                            x.appendChild(option1);
                            x.setAttribute("class", "form-control");
                            var textoCelda = x;
                        } else if (j == 5) {
                            var x = document.createElement("select");
                            var option1 = document.createElement("option");
                            option1.setAttribute("value", asignaturas[i]["observaciones"]);
                            var option1Texto = document.createTextNode(asignaturas[i]["nombre_observaciones"]);
                            option1.appendChild(option1Texto);
                            x.setAttribute("name", "select2");
                            x.setAttribute("id", i + 10);
                            x.appendChild(option1);
                            x.setAttribute("class", "form-control");
                            var textoCelda = x;
                        }
                        celda.appendChild(textoCelda);
                        hilera.appendChild(celda);
                    }
                    tblBody.appendChild(hilera);
                }
                tabla.className += "table  table-bordered";
                tabla.setAttribute("id", "calificaciones")
                tabla.appendChild(thead);
                tabla.appendChild(tblBody);
                body.appendChild(tabla);
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
        var myTableArray = [];
        var elemento = 0;
        var elemento2 = 10;
        $("table#calificaciones tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() {
                    if ($(this).find("select").length > 0) {
                        var select = $(this).find("select");
                        if (select.attr("id") == elemento) {
                            //  console.log($("#" + elemento + " option:selected").val());
                            arrayOfThisRow.push(($("#" + elemento + " option:selected").val()));
                        } else if (select.attr("id") == elemento2) {
                            //console.log($("#" + elemento2 + " option:selected").val());
                            arrayOfThisRow.push(($("#" + elemento2 + " option:selected").val()));
                        }
                        //  arrayOfThisRow.push(($("#select option:selected").val()));
                        //  arrayOfThisRow.push(($("#select2 option:selected").val()));
                    } else
                    if ($(this).text() == "") {
                        var input = $(this).find("input");
                        arrayOfThisRow.push(input.val());
                    } else {
                        arrayOfThisRow.push($(this).text());
                    }
                });
                myTableArray.push(arrayOfThisRow);
                elemento++;
                elemento2++;
            }
        });
       // console.log(myTableArray);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/sendArrayRepro',
            data: {
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'curp': curp,
                'clave_grupo': clave_grupo,
            },
            success: function(datas) {
                console.log(datas);
                window.location = datas.link;
            }
        });
    });
</script>


@endsection