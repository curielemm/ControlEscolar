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
            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
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
<!--div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Lista de Materias del RVOE: {{$plan->rvoe}}</h3>
            <div class="card-body">
                <!--div id="tabla" name="tabla">
                </div-->
                <!--center>
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

</div-->


<!--input type="button" name="boton" id="boton" value="Genera una tabla"-->



<script type="text/javascript">
    $(document).ready(function() {
       // $("#boton").click(function() {
            var rvoe = $('#rvoe').val();
            var vigencia = $('#vigencia').val();
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
                url: '/consultajax4',
                data: {
                    "rvoe": rvoe,
                    "vigencia": vigencia
                },
                success: function(data) {
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
       // });
    });
</script>

@endsection