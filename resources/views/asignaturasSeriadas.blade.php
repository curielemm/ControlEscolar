@extends('layouts.app')
<title>Asignaturas Seriadas</title>
@section('content')
<div class="row">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">{{$plan->nombre_plan}}</h3>
            <h3 class="text-center">Lista de Materias del RVOE: {{$plan->rvoe}} </h3>
            <h3 class="text-center">Vigencia {{$plan->vigencia}}</h3>
            <h4 class="text-center">*Agregue las Claves de Asignatura que son antecesoras a cada asignatura*</h4>
            <div class="card-body">
            <div><a type="button" class="btn btn-success" href="{{route('agregarSeriacionCSV',[$plan->rvoe,$plan->vigencia])}}"><span class="fa fa-file-excel-o" aria-hidden="true"> Agregar Claves de Seriación con Archivo .csv</span></a></div>
                        
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Clave Asignatura</th>
                            <th>Nombre Asignatura</th>
                            <th>Periodo</th>
                            <th>Claves de Seriación</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaturas as $materia)
                        <tr id="tr{{$loop->iteration}}">
                            <td>{{$loop->iteration}}</td>
                            <td> {{$materia->clave_asignatura}} </td>
                            <td>{{$materia->nombre_asignatura}} <br>Materias antecesoras: {{$materia->seriacion}}</td>
                            <td>{{$materia->no_periodo}}</td>

                            <td>
                                <form action="{{route('agregarSeriacion')}}" method="post">
                                    {{csrf_field()}}

                                    <button class="btn btn-primary" name="listas{{$loop->iteration}}" id="boton"><span class="fa fa-plus" aria-hidden="true">Agregar Campo</span></button>

                                    <div id="listas{{$loop->iteration}}">
                                        <input class="form-control" id="clave_asignatura" name="clave_asignatura" style="display:none" readonly value="{{$materia->clave_asignatura}}" type="text">
                                        <label for="exampleInputEmail1">Claves de Seriación:</label>
                                        <div class="form-group"><input class="form-control" type="text" name="campo[]" required></div>
                                        <input type="hidden" class="form-control" name="rvoe" id="rvoe" value="{{$plan->rvoe}}" style="visibility: hidden;">
                                        <input type="hidden" class="form-control" name="vigencia" id="vigencia" value="{{$plan->vigencia}}" style="visibility: hidden;">

                                    </div>
                                    <button class="btn btn-success">Añadir Claves</button>
                                </form>
                            </td>


                        </tr>


                        @endforeach
                    </tbody>
                </table>
                {{$asignaturas->render()}}
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


<script>
    /* $(function() {
        $('button').on('click', 'tr', function() {
            alert($(this).prop('id'));
        });
    });*/


    var x = 0;
    var campos_max = 10; //max de 10 campos

    $(document).on('click', '#boton', function(e) {
        e.preventDefault();
        // console.log("name de boton " + $(this).prop('name'));
        var div = "#" + $(this).prop('name');
        if (x < campos_max) {
            $(div).append('<div class="form-group">\
                        <input type="text" class="form-control" id="' + x + '" name="campo[]">\
                        <button id="' + x + '" class="btn btn-danger" class="remover_campo"><span class="fa fa-trash" aria-hidden="true">Eliminar</span></button>\
                        </div> ');
            x++;
        }
        console.log("valor de x: " + x);
        console.log("valor de campos_max: " + campos_max);

    });

    // Remover o div anterior
    $(document).on("click", ".btn-danger", function(e) {
        //e.preventDefault();
        var propi = "#" + $(this).prop('id')

        console.log('voy a eliminar a: ' + propi);
        $(propi).parent('div').remove();
        x--;
        console.log("valor de x despues de remover " + x);
    });

    /*
    var campos_max = 10; //max de 10 campos

    var x = 0;
    $('#add_field').click(function(e) {
        e.preventDefault(); //prevenir novos clicks
        if (x < campos_max) {
            $('#listas').append('<div>\
                        <input type="text" name="campo[]">\
                        <a href="#" class="remover_campo">Remover</a>\
                        </div>');
            x++;
        }
    });
    // Remover o div anterior
    $('#listas').on("click", ".remover_campo", function(e) {
        e.preventDefault();
        $(this).
        x--;
    });*/
</script>
@endsection