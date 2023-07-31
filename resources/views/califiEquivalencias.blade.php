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

    .my-custom-scrollbar {
        position: relative;
        height: 310px;
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
            <input type="hidden" id="folio_equivalencia" name="folio_equivalencia" value="{{$alumno->folio_equivalencia}}">
            <div class="card-body">
                <h4 class="text-center">Agregue las Calificaciones Equivalentes al Plan de Estudios</h4>
                <h4 class="text-center">Folio Equivalencia: {{$alumno->folio_equivalencia}}</h4>
            </div>
            <div class="card-body">
                <form id="calif">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered" id="calificaciones">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clave Asignatura</th>
                                    <th>Nombre Asignatura</th>
                                    <th>Periodo</th>
                                    <th>Calificacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignaturas as $asignatura)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$asignatura->clave_asignatura}}</td>
                                    <td>{{$asignatura->nombre_asignatura}}</td>
                                    <td>{{$asignatura->no_periodo}}</td>
                                    <td><input type="number" min="0" class="form-control" name="cali" id="cali"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary">Cargar Calificaciones</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('submit', '#calif', function() {
        event.preventDefault();
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var curp = $('#curp').val();
        var clave_grupo = $('#clave_grupo').val();
        var folio_equivalencia = $('#folio_equivalencia').val();
        var myTableArray = [];
        $("table#calificaciones tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() {
                    if ($(this).text() == "") {
                        var input = $(this).find("input");
                        arrayOfThisRow.push(input.val());
                    } else {
                        arrayOfThisRow.push($(this).text());
                    }
                });
                myTableArray.push(arrayOfThisRow);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/sendArrayEq',
            data: {
                "array": myTableArray,
                  "rvoe": rvoe,
                  "vigencia": vigencia,
                  'curp': curp,
                  'clave_grupo': clave_grupo,
                  'folio_equivalencia': folio_equivalencia,
            },
            success: function(datas) {
                /* window.location = datas.link;
                 console.log(datas);*/
                console.log(datas);
            }
        });
        /* $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: 'POST',
              url: '/sendArrayEq',
              data: {
                  "array": myTableArray,
                  "rvoe": rvoe,
                  "vigencia": vigencia,
                  'curp': curp,
                  'clave_grupo': clave_grupo,
                  'folio_equivalencia': folio_equivalencia,
              },
              success: function(datas) {
                  //console.log(datas);
              }
          });*/
    });
</script>
@endsection