@extends('layouts.app')
<title>Materias</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

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
                <h5>Simbología:</h5>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn bg-primary text-light" disabled>Cursando</button>
                    <button type="button" class="btn bg-success text-light" disabled>Aprobada</button>
                    <button type="button" class="btn bg-danger text-light" disabled>Reprobada</button>
                    <button type="button" class="btn bg-secondary text-light" disabled>No Cursada</button>
                    <button type="button" class="btn bg-warning " disabled>Recursando</button>
                </div>
            </div>
            <div class="card-body">

                <div id="tabla" name="tabla">
                </div>
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
            url: '/cons',
            data: {
                "rvoe": rvoe,
                "vigencia": vigencia,
                'curp': curp,
                'clave_grupo': clave_grupo
            },
            success: function(datas) {
                data = datas[1];
                data2 = datas[0];
                console.log(data2);
                console.log(data);
                console.log(data[1]["numeros"])
                console.log(data[1]["comun"])
                var body = document.getElementById("tabla");
                var tabla = document.createElement("table");
                var thead = document.createElement("thead");
                var tblBody = document.createElement("tbody");
                var k = 0;
                var l = 1;
                var hilerah = document.createElement("tr");
                for (var i = 0; i < data[1]["numeros"]; i++) {
                    k = i + l;
                    var celdath = document.createElement("th");
                    var textoCeldath = document.createTextNode(data[1]["comun"] + " " + k);
                    celdath.appendChild(textoCeldath);
                    hilerah.appendChild(celdath);
                }
                thead.appendChild(hilerah);
                for (var i = 0; i < data[1]["numeros"]; i++) {
                    var aux = 0;
                    var hilera = document.createElement("td");
                    for (var j = 0; j < data.length; j++) {
                        if (data[j]["no_periodo"] == i + 1) {
                            var tablita = document.createElement("table");
                            var hilerita = document.createElement("tr");
                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(data[j]["clave_asignatura"] + "\n" + data[j]["nombre_asignatura"]);
                            for (var k = 0; k < data2.length; k++) {
                                if (data2[k]["clave_asignatura"] == data[j]["clave_asignatura"]) {
                                    if (data2[k]["status_aa"] == 1) {
                                        celda.className += "text-light bg-primary";
                                    } else if (data2[k]["status_aa"] == 2) {
                                        celda.className += "text-light bg-success";
                                    } else if (data2[k]["status_aa"] == 3) {
                                        celda.className += "text-light bg-danger";
                                    } else if (data2[k]["status_aa"] == 4) {
                                        celda.className += "text-light bg-secondary";
                                    } else if (data2[k]["status_aa"] == 5) {
                                        celda.className += " bg-warning";
                                    } else {
                                        celda.className += "text-light bg-secondary";
                                    }
                                }
                            }

                            celda.appendChild(textoCelda);
                            hilerita.appendChild(celda);
                            tablita.appendChild(hilerita);
                            hilera.appendChild(tablita);
                        } else {

                        }
                    }
                    tblBody.appendChild(hilera);
                }
                thead.className += "thead-light";
                tabla.className += "table  table-responsive table-striped";
                tabla.appendChild(thead);
                tabla.appendChild(tblBody);
                body.appendChild(tabla)

            }
        });
    });
</script>

@endsection