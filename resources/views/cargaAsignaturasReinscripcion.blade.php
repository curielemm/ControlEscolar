@extends('layouts.app')
<title>Seleccionar Asignaturas</title>
@section('content')
<style>
    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 350px;
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
            <h3 class="text-center">Plan de Estudios del RVOE: {{$plan->rvoe}} Vigencia: {{$plan->vigencia}} </h3>
            <h3 class="text-center">Grupo: {{$grupo->nombre_grupo}} Periodo Escolar {{$grupo->fecha_ini}} al {{$grupo->fecha_fin}}</h3>
            <h3 class="text-center"> Datos de Alumno: {{$alumno->curp }} {{$alumno->matricula}} {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno}}</h3>
            <div class="card-header">
                <div>
                    <form action="{{route('listaAlumnosReinscritos',[encrypt($grupo->clave_grupo),encrypt($plan->rvoe),encrypt($plan->vigencia)])}}" method="get">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar
                        </button>
                    </form>
                </div>
                <h5 class="text-center">"Selecciona las asignaturas susceptibles a cursar"</h5>
            </div>
            <div class="card-body">

                <div class="container-fluid">
                    <form id="asig">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <input type="hidden" id="rvoe" name="rvoe" value="{{$plan->rvoe}}">
                            <input type="hidden" id="vigencia" name="vigencia" value="{{$plan->vigencia}}">
                            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">
                            <input type="hidden" id="curp" name="curp" value="{{$alumno->curp}}">
                            <table id="asignaturas" class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectall" name="selectall"> Todos </th>
                                        <th>#</th>
                                        <th>Clave Asignatura</th>
                                        <th>Nombre Asignatura</th>
                                        <th>No. Periodo</th>
                                        <th>Observacion</th>
                                    </tr>

                                    @foreach($asignaturas as $asignatura)
                                    <tr>
                                        <td><input type="checkbox" class="case"></td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$asignatura->clave_asignatura}}</td>
                                        <td>{{$asignatura->nombre_asignatura}}</td>
                                        <td>{{$asignatura->no_periodo}}</td>
                                        <td>{{$asignatura->a}}</td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                        <div>
                            <input type="hidden" id="array" name="array" value="">
                            <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary"><i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                Cargar Asignaturas</button>
                        </div>
                    </form>
                </div>
                </thead>

            </div>

        </div>
    </div>
</div>

<script>
    $(document).on('click', '#selectall', function() {
        console.log("estoy aqui");
        $(".case").prop("checked", this.checked);

    });

    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case").on("click", function() {
        if ($(".case").length == $(".case:checked").length) {
            $("#selectall").prop("checked", true);
        } else {
            $("#selectall").prop("checked", false);
        }
    });
</script>

<script>
    $(document).on('submit', '#asig', function() {
        event.preventDefault();
        var myTableArray = [];
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var clave_grupo = $('#clave_grupo').val();
        var curp = $('#curp').val();
        $("table#asignaturas tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() {
                    if ($(this).text() == "") {
                        var input = $(this).find("input");
                        if ($(this).find("input:checked").length > 0) {
                            arrayOfThisRow.push(1);
                        } else {
                            arrayOfThisRow.push(0);
                        }
                    } else {
                        arrayOfThisRow.push($(this).text());
                    }
                });
                myTableArray.push(arrayOfThisRow);
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
            url: '/cargaAsignaturas',
            data: {
                "curp": curp,
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'clave_grupo': clave_grupo,


            },
            success: function(datas) {
                // window.location = datas.link;
                console.log(datas);
                location.reload(true);
            }
        });
    });
</script>
@endsection