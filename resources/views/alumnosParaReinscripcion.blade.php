@extends('layouts.app')
<title>ALUMNOS REINSCRIPCIÓN</title>
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

    .my-custom-scrollbar {
        position: relative;
        height: 370px;
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
        <div>
                   <form action="{{route('gruposReinscripcion',[encrypt($datos->rvoe),encrypt($datos->vigencia)])}}" method="get">
                   {{csrf_field()}}
                   <button type="submit"  class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                        Regresar
                    </button>
                    </form>
                </div>
            <h4 class="text-center">LISTA DE ALUMNOS PARA REINSCRIPCIÓN AL {{$grupo->no_periodo}}° GRUPO {{$grupo->nombre_grupo}} DE {{$datos->nombre_plan}} VIGENCIA {{$datos->vigencia}} </h4>
            <div class="card-body">

                <div class="container-fluid">
                    <form id="calif">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <input type="hidden" id="rvoe" name="rvoe" value="{{$datos->rvoe}}">
                            <input type="hidden" id="vigencia" name="vigencia" value="{{$datos->vigencia}}">
                            <input type="hidden" id="clave_grupo" name="clave_grupo" value="{{$grupo->clave_grupo}}">

                            <table id="alumnos" class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectall" name="selectall"> Todos </th>
                                        <th>#</th>
                                        <th>CURP</th>
                                        <th>Matrícula</th>
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alumnos as $alumno)
                                    <tr>
                                        <td><input type="checkbox" class="case"></td>
                                        <td>{{$loop->iteration}}</td>
                                        <td><a href="{{route('avance',[encrypt($datos->rvoe),encrypt($datos->vigencia),encrypt($alumno->curp),encrypt($grupo->clave_grupo)])}}">{{$alumno->curp}}</a></td>
                                        <td>{{$alumno->matricula}}</td>
                                        <td>{{$alumno->nombre}}</td>
                                        <td>{{$alumno->apellido_paterno}}</td>
                                        <td>{{$alumno->apellido_materno}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <input type="hidden" id="array" name="array" value="">
                            <button type="submit" id="cargar" name="cargar" onclick="return confirm('¿La Información es Correcta?, no se podrá hacer cambios posteriormente')" class="btn btn-primary"><i class="fa fa-cloud-upload" aria-hidden="true"></i>
 Cargar Alumnos</button>
                        </div>
                    </form>
                </div>

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
    $(document).on('submit', '#calif', function() {
        event.preventDefault();
        var myTableArray = [];
        var rvoe = $('#rvoe').val();
        var vigencia = $('#vigencia').val();
        var clave_grupo = $('#clave_grupo').val();
        $("table#alumnos tr").each(function() {
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
        console.log(myTableArray);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/cargaReinscripcion',
            data: {
                "array": myTableArray,
                "rvoe": rvoe,
                "vigencia": vigencia,
                'clave_grupo': clave_grupo,

            },
            success: function(datas) {
                window.location = datas.link;
                //console.log(datas);
            }
        });
    });
</script>


@endsection