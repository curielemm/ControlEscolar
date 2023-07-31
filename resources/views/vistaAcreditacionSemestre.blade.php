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
            <h3 class="text-center">{{$plan->nombre_plan}}</h3>
            <h4 class="text-center">Plan de Estudios del RVOE: {{$plan->rvoe}} Vigencia: {{$plan->vigencia}} </h4>
            <h4 class="text-center">Grupo: {{$grupo->nombre_grupo}} Periodo Escolar {{$grupo->fecha_ini}} al {{$grupo->fecha_fin}}</h4>
            <div class="card-body">
                <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
                <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
                <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">
                <form id="asig">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="tablita" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CURP</th>
                                    <th>Matricula</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    @for($i = 0; $i < sizeof($arrayMaterias); $i++) <th>{{$arrayMaterias[$i]->nombre_asignatura}}</th>
                                        @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < sizeof($datosAlumno); $i++) <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$datosAlumno[$i]->curp}}</td>
                                    <td>{{$datosAlumno[$i]->matricula}}</td>
                                    <td>{{$datosAlumno[$i]->nombre}}</td>
                                    <td>{{$datosAlumno[$i]->apellido_paterno}}</td>
                                    <td>{{$datosAlumno[$i]->apellido_materno}}</td>

                                    @for($j = 0 ; $j< sizeof($arrayMaterias); $j++) @if($datosUnidos[$i][$j][0]->observaciones != 1)
                                        <td class="table-primary">
                                            <a href="{{route('verActa',[encrypt($datosUnidos[$i][$j][0]->curp),encrypt($grupo->clave_grupo),encrypt($plan->rvoe),encrypt($plan->vigencia)])}}">
                                                @if($datosUnidos[$i][$j][0]->status_inscripcion == 0)
                                                -
                                                @endif
                                                @if($datosUnidos[$i][$j][0]->status_inscripcion == 1)
                                                {{$datosUnidos[$i][$j][0]->promedio_final}}
                                                @endif
                                            </a>
                                        </td>
                                        @endif
                                        @if($datosUnidos[$i][$j][0]->observaciones == 1)
                                        <td>
                                            {{$datosUnidos[$i][$j][0]->promedio_final}}
                                        </td>
                                        @endif
                                        @endfor
                                        </tr>
                                        @endfor
                            </tbody>
                        </table>
                    </div>
                    <div>
                            <input type="hidden" id="array" name="array" value="">
                            <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>
                                Validar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript">
    var arrayMaterias = ['IED0101', 'LJU0102', 'DRO0103', 'ING0104', 'MEI0105', 'EPL0106'];
    var arrayCurps = ['AAJM940102MDFMAR05',
        'AUCJ790125HVZANN03',
        'FOAA000106HACLZLA5',
        'GUGK871103MACZRR07',
        'COLE990126MAONPL00',
        'GAJL021210MAOCRSA1',
        'LOVS940502HOCALM06',
        'RAPG960110HOACNL08',
        'VASK941218MOCRSR03',
        'CUDE950606HOCRZM05'
    ];
    var rvoe = "20206141419";
    var vigencia = "2015-2016";
    var clave_grupo = '1ICJO-202062020-20212015';
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/datosSem',
            data: {
                "arrayMaterias": arrayMaterias,
                "arrayCurps": arrayCurps,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'clave_grupo': clave_grupo,
            },
            success: function(datas) {
                console.log(datas);
            }
        });
    });
</script>

<script>
    $(document).on('submit', '#asig', function() {
        event.preventDefault();
        var myTableArray = [];
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var clave_grupo = $('#clave_grupo').val();
        $("table#tablita tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() { 
                        arrayOfThisRow.push($(this).text());
                });
                myTableArray.push(arrayOfThisRow);
            }
        });
        console.log(myTableArray);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/validarSemestre',
            data: {
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'clave_grupo': clave_grupo,


            },
            success: function(datas) {
               //  window.location = datas.link;
               // console.log(datas);
                //   location.reload(true);
            }
        });
    });
</script>
@endsection