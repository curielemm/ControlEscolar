@extends('layouts.app')
<title>Validación por Asignatura</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<style>
    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    #calificaciones {
        width: 58%;
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

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">{{$plan->nombre_plan}}</h3>
            <h4 class="text-center">Plan de Estudios del RVOE: {{$plan->rvoe}} Vigencia: {{$plan->vigencia}} </h4>
            <h4 class="text-center">Grupo: {{$grupo->nombre_grupo}} Periodo Escolar {{$grupo->fecha_ini}} al {{$grupo->fecha_fin}}</h4>
            <form action="{{route('reporteSemestral',[encrypt($plan->rvoe),encrypt($clave_grupo),encrypt($plan->vigencia)])}}" method="GET">
                <div style="text-align: right"><button id="semestral" name="semestral" type="submit" class="btn btn-success" disabled>Ir a Reporte Semestral</button></div>
            </form>
            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$clave_grupo}}">
            <input type="hidden" id="parciales" name="parciales" value="">
            <input type="hidden" id="clave_asignatura" name="clave_asignatura" value="">
            <input type="hidden" id="mates" name="mates" value="{{$asignaturas}}">
            <div class="card-header">
                <h4>Seleccione una asignatura para validar calificaciones </h4>
                <div class="form-group">
                    <select id="asignatura" title="option" name="asignatura" class="form-control">
                        @foreach($asignaturas as $a)
                        <option id="opciones" class="form-control" value="{{$a['clave_asignatura']}}">
                            {{$a['nombre_asignatura']}}
                        </option>@endforeach
                        <option hidden selected>Selecciona una opción</option>
                    </select>
                </div>
                <h5 id="lmx" class="text-center"></h5>
            </div>

            <div class="card-body">
                <form id="calif">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <div id="tabla" name="tabla">
                        </div>
                    </div>
                    <hr>
                    <h5>Fechas de Parciales y Ordinario</h5>
                    <hr>
                    <div id="fechitas" name="fechitas">

                    </div>

                    <h5>Datos del Docente</h5>
                    <hr>
                    <div id="docente" name="docente">

                    </div>
                    <div>
                        <input type="hidden" id="array" name="array" value="">
                        <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary">Validar Calificaciones</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#asignatura', function() {
            // console.log($(this).val());
            var asig = $('#lmx');
            textoasignatura = $('#asignatura option:selected').text();
            asig.text(textoasignatura);
            var clave_materia = $(this).val();
            var asignatura = $('#clave_asignatura');
            asignatura.val(clave_materia);
            var rvoe = $('#rvoe').val();
            var vigencia = $('#vigencia').val();
            var clave_grupo = $('#clave_grupo').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/consultajaxT',
                data: {
                    "clave_materia": clave_materia,
                    "rvoe": rvoe,
                    'vigencia': vigencia,
                    'clave_grupo': clave_grupo
                },

                success: function(data) {
                    // console.log(data);
                    no_parcial = data[0];
                    no_parciales = no_parcial[0]['no_parciales'];
                    asignaturas = data[1];
                    // total = data[2];

                    var docente = asignaturas;
                    // console.log(docente[0]["ndocente"] + " " + docente[0]["nap"] + " " + docente[0]["nam"]);
                    //  console.log(no_parciales);
                    console.log(asignaturas);
                    var body2 = $('#tabla');
                    var body = document.getElementById("tabla");
                    while (body.firstChild) {
                        body.removeChild(body.firstChild);
                    }
                    if (asignaturas === "Proceso de Captura de Calificación No Completado") {
                        body2.html('<div class="alert alert-danger" role="alert">!Proceso de Captura de Calificación No Completado!</div>');
                    } else if (asignaturas === "Asignatura Validada") {
                        body2.html('<div class="alert alert-success" role="alert">!Asignatura Validada Correctamente!</div>');

                    } else {
                        var tabla = document.createElement("table");
                        var thead = document.createElement("thead");
                        var tblBody = document.createElement("tbody");
                        var hilerah = document.createElement("tr");
                        var columnas = 11 + no_parciales;
                        var filas = asignaturas.length;
                        var valor = 0;
                        for (var i = 0; i < columnas; i++) {
                            valor = i + 1 - 6;
                            var celdath = document.createElement("th");
                            if (i == 0) {
                                var textoCeldath = document.createTextNode("#");
                            } else if (i == 1) {
                                var textoCeldath = document.createTextNode("CURP");
                            } else if (i == 2) {
                                var textoCeldath = document.createTextNode("Matricula");
                            } else if (i == 3) {
                                var textoCeldath = document.createTextNode("Nombre(s)");
                            } else if (i == 4) {
                                var textoCeldath = document.createTextNode("Apellido Paterno");
                            } else if (i == 5) {
                                var textoCeldath = document.createTextNode("Apellido Materno");
                            } else if (i == columnas - 1) {
                                var textoCeldath = document.createTextNode("Observaciones");
                            } else if (i == columnas - 2) {
                                var textoCeldath = document.createTextNode("% Asistencia");
                            } else if (i == columnas - 3) {
                                var textoCeldath = document.createTextNode("Calif. Final");
                            } else if (i == columnas - 4) {
                                var textoCeldath = document.createTextNode("Prom. Final");
                            } else if (i == columnas - 5) {
                                var textoCeldath = document.createTextNode("Ordinario");
                            } else {
                                var textoCeldath = document.createTextNode("Parcial " + valor);
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
                                    if (j == 7) {
                                        if (asignaturas[i]["pl2"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl2"]);
                                        }
                                    } else if (j == 6) {
                                        if (asignaturas[i]["pl1"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl1"]);
                                        }
                                    } else if (j == 5) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_materno"]);
                                    } else if (j == 4) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_paterno"]);
                                    } else if (j == 3) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre"]);
                                    } else if (j == 0) {
                                        var textoCelda = document.createTextNode(i + 1);
                                    } else if (j == 1) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["curp"]);
                                    } else if (j == 2) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["matricula"]);
                                    } else if (j == 15) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre_observaciones"]);
                                    } else if (j == 14) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["porcentaje_asistencia"] + "%");
                                    } else if (j == 13) {
                                        if (asignaturas[i]["promedio_final"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["promedio_final"]);
                                        }
                                    } else if (j == 12) {
                                        if (asignaturas[i]["final"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["final"]);
                                        }
                                    } else if (j == 11) {
                                        if (asignaturas[i]["ordinario"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["ordinario"]);
                                        }
                                    } else if (j == 10) {
                                        if (asignaturas[i]["pl5"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl5"]);
                                        }
                                    } else if (j == 9) {
                                        if (asignaturas[i]["pl4"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl4"]);
                                        }
                                    } else if (j == 8) {
                                        if (asignaturas[i]["pl3"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl3"]);
                                        }
                                    }
                                } else if (no_parciales == 4) {
                                    if (j == 6) {
                                        if (asignaturas[i]["pl1"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl1"]);
                                        }
                                    } else if (j == 5) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_materno"]);

                                    } else if (j == 4) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_paterno"]);

                                    } else if (j == 3) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre"]);
                                    } else if (j == 0) {
                                        var textoCelda = document.createTextNode(i + 1);
                                    } else if (j == 1) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["curp"]);
                                    } else if (j == 2) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["matricula"]);
                                    } else if (j == 14) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre_observaciones"]);
                                    } else if (j == 13) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["porcentaje_asistencia"] + "%");
                                    } else if (j == 12) {
                                        if (asignaturas[i]["promedio_final"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["promedio_final"]);
                                        }
                                    } else if (j == 11) {
                                        if (asignaturas[i]["final"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["final"]);
                                        }
                                    } else if (j == 10) {
                                        if (asignaturas[i]["ordinario"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["ordinario"]);
                                        }
                                    } else if (j == 9) {
                                        if (asignaturas[i]["pl4"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl4"]);
                                        }
                                    } else if (j == 8) {
                                        if (asignaturas[i]["pl3"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl3"]);
                                        }
                                    } else if (j == 7) {
                                        if (asignaturas[i]["pl2"] == 0 && asignaturas[i]["status_inscripcion"] == 0) {
                                            var textoCelda = document.createTextNode("-");
                                        } else {
                                            var textoCelda = document.createTextNode(asignaturas[i]["pl2"]);
                                        }
                                    }

                                } else if (no_parciales == 3) {
                                    if (j == 4) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_materno"]);

                                    } else if (j == 3) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["apellido_paterno"]);

                                    } else if (j == 2) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre"]);

                                    } else if (j == 0) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["curp"]);
                                    } else if (j == 1) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["matricula"]);
                                    } else if (j == 11) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["porcentaje_asistencia"] + "%");

                                    } else if (j == 10) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["promedio_final"]);

                                    } else if (j == 9) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["final"]);

                                    } else if (j == 8) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["ordinario"]);

                                    } else if (j == 7) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl3"]);

                                    } else if (j == 6) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl2"]);

                                    } else if (j == 5) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl1"]);

                                    }

                                } else if (no_parciales == 2) {
                                    if (j == 3) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl2"]);

                                    } else if (j == 2) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl1"]);

                                    } else if (j == 0) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                    } else if (j == 1) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                    } else if (j == 6) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["promedio_final"]);

                                    } else if (j == 5) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["final"]);

                                    } else if (j == 4) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["ordinario"]);
                                    }
                                } else if (no_parciales == 1) {
                                    if (j == 2) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["pl1"]);

                                    } else if (j == 0) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["clave_asignatura"]);
                                    } else if (j == 1) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["nombre_asignatura"]);
                                    } else if (j == 5) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["promedio_final"]);

                                    } else if (j == 4) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["final"]);
                                    } else if (j == 3) {
                                        var textoCelda = document.createTextNode(asignaturas[i]["ordinario"]);
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
                        tabla.setAttribute("id", "calificaciones");
                        //tabla.style.width = "10%";
                        tabla.appendChild(thead);
                        tabla.appendChild(tblBody);
                        body.appendChild(tabla);

                        var numeroDatos = no_parciales + 1;
                        //aqui creamos la tabla para las fechas;

                        var date1 = document.getElementById("fechitas");
                        while (date1.firstChild) {
                            date1.removeChild(date1.firstChild);
                        }
                        var dataTabla = document.createElement("table");
                        var theadDate = document.createElement("thead");
                        var thileraDate = document.createElement("tr");
                        var dateBody = document.createElement("tbody");
                        var valor2 = 0;
                        var valor3 = 0;
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
                                if (b == numeroDatos - 1) {
                                    //  console.log("estoy en el if");
                                    // console.log(asignaturas[0]["fordinario"]);
                                    var textoCeldaDate = document.createTextNode(asignaturas[0]["fordinario"]);
                                    celdaDate.appendChild(textoCeldaDate);
                                    dateHilera.appendChild(celdaDate);
                                } else {
                                    valor3 = b + 1;
                                    // console.log("fpl" + valor3);

                                    var textoCeldaDate = document.createTextNode(asignaturas[0]["fpl" + valor3]);
                                    celdaDate.appendChild(textoCeldaDate);
                                    dateHilera.appendChild(celdaDate);
                                }
                            }
                            dateBody.appendChild(dateHilera);
                        }
                        dataTabla.className += "table table-bordered";
                        dataTabla.setAttribute("id", "fechas")
                        dataTabla.appendChild(theadDate);
                        dataTabla.appendChild(dateBody);
                        date1.appendChild(dataTabla);

                        // nueva tabla
                        var divDocente = document.getElementById("docente");
                        while (divDocente.firstChild) {
                            divDocente.removeChild(divDocente.firstChild);
                        }

                        var docenteTabla = document.createElement("table");
                        var theadDateD = document.createElement("thead");
                        var thileraDateD = document.createElement("tr");
                        var dateBodyD = document.createElement("tbody");
                        for (var f = 0; f < 3; f++) {
                            var celdathdd = document.createElement("th");
                            if (f == 0) {
                                var textoCeldathdd = document.createTextNode("Nombre");
                            } else if (f == 1) {
                                var textoCeldathdd = document.createTextNode("Apellido Paterno");
                            } else if (f == 2) {
                                var textoCeldathdd = document.createTextNode("Apellido Materno");
                            }
                            celdathdd.appendChild(textoCeldathdd);
                            thileraDateD.appendChild(celdathdd);
                        }
                        theadDateD.appendChild(thileraDateD);

                        for (var a = 0; a < 1; a++) {
                            var dateHilerad = document.createElement("tr");
                            for (var g = 0; g < 3; g++) {
                                var celdaDated = document.createElement("td");
                                if (g == 0) {
                                    var textoCeldaDated = document.createTextNode(docente[0]["ndocente"]);
                                    celdaDated.appendChild(textoCeldaDated);
                                    dateHilerad.appendChild(celdaDated);
                                } else if (g == 1) {
                                    var textoCeldaDated = document.createTextNode(docente[0]["nap"]);
                                    celdaDated.appendChild(textoCeldaDated);
                                    dateHilerad.appendChild(celdaDated);
                                } else if (g == 2) {
                                    var textoCeldaDated = document.createTextNode(docente[0]["nam"]);
                                    celdaDated.appendChild(textoCeldaDated);
                                    dateHilerad.appendChild(celdaDated);
                                }
                            }
                            dateBodyD.appendChild(dateHilerad);
                        }
                        docenteTabla.className += "table table-bordered";
                        docenteTabla.setAttribute("id", "docente")
                        docenteTabla.appendChild(theadDateD);
                        docenteTabla.appendChild(dateBodyD);
                        divDocente.appendChild(docenteTabla);

                    }
                }

            });
        });

    });
</script>

<script>
    $(document).on('submit', '#calif', function() {
        event.preventDefault();
        var input = $("#array");
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var clave_grupo = $('#clave_grupo').val();
        var clave_asignatura = $('#clave_asignatura').val();
        var myTableArray = [];
        
        console.log('le di al boton validar');
        $("table#calificaciones tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() {

                    arrayOfThisRow.push($(this).text());
                    //  }
                });
                myTableArray.push(arrayOfThisRow);
            }
        });

        /* $("table#fechas tr").each(function() {
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
         });*/
        //  console.log(myTableArray2);
        //   console.log(myTableArray);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/sendArray2',
            data: {
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'clave_grupo': clave_grupo,
                'clave_asignatura': clave_asignatura,
            },
            success: function(datas) {
                console.log(datas)
                // window.location = datas.link;
                console.log(datas);
            }
        });
        //input.val(myTableArray);
        //  event.currentTarget.submit();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        mates = <?= json_encode(
                    $asignaturas,
                    JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS
                ) ?>;

        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var clave_grupo = $('#clave_grupo').val();
        console.log(mates);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/completado',
            data: {

                "rvoe": rvoe,
                'vigencia': vigencia,
                'clave_grupo': clave_grupo
            },
            success: function(datas) {
                // window.location = datas.link;

                console.log("este es el valor " + datas);
                semestral = $('#semestral');
                total = datas;
                total = 1;
                if (total === 1) {
                    semestral.prop('disabled', false);
                }
            }
        });
    });
</script>
@endsection