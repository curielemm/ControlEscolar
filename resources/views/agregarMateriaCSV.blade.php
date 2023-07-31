@extends('layouts.app')
<title>Agregar Materias Excel</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true"> Regresar a Panel </span></button>
                    </form>
                </div>

                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                @if(session()->has('message2'))
                <div class="alert alert-danger">
                    {{ session()->get('message2') }}
                </div>
                @endif
                <div class="card-header">{{ __('Agregar Materias de Nivel Superior') }}

                    <div class="form-inline pull-right">

                        <a href="{{Storage::url('formato_asignaturas.csv')}}" type="submit" class="btn btn-primary"><span class="fa fa-download" aria-hidden="true"> Descargar Formato</span></a>

                    </div>
                </div>
                <div class="card-heading">
                    <center>
                        <h4>Rellene el Formulario</h4>

                        <h5>* Campos Obligatorios</h5>

                    </center>
                </div>
                <div class="card-body">

                    <form action="{{ route('agregarData')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Nombre Institución:</label>
                            <div class="col-sm-9">
                                <select id="clave_cct" title="option" name="clave_cct" class="form-control" required>
                                    @foreach($institucionSU as $g)
                                    <option id="opciones" class="form-control" value="{{$g['clave_cct']}}">
                                        {{$g['nombre_institucion']}}
                                    </option>@endforeach
                                    <option hidden selected>Selecciona una opción</option>
                                </select>
                                {!! $errors->first('clave_cct','<small class="text-danger">:message</small><br>') !!}
                                <input type="text" name="nivel" value="1" style="visibility:hidden">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Nombre de la Licenciatura:</label>
                            <div class="col-sm-9">
                                <select id="fk_rvoe" title="option" name="fk_rvoe" class="form-control" required>
                                </select>
                                {!! $errors->first('fk_rvoe','<small class="text-danger">:message</small><br>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Tipo Periodo</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="tipo_periodo" id="tipo_periodo" required></select>
                                {!! $errors->first('tipo_periodo','<small class="text-danger">:message</small><br>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Archivo de Excel .csv</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file" id="file" accept=".csv" required>
                                {!! $errors->first('file','<small class="text-danger">:message</small><br>') !!}
                            </div>
                        </div>

                        <div class="form-group row" id="input" name="input">

                        </div>
                        <center>
                            <div class="col-sm-10">

                                <button type="submit" class="btn btn-primary"> Agregar Materia</button>

                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function() {

        $(document).on('change', '#clave_cct', function() {
            //detectamos el evento change
            var value = $(this).val(); //sacamos el valor del select
            var carreras = $('#fk_rvoe');
            // var periodos = $('#semestre_cuatrimestre');
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            $.ajax({

                type: 'POST',

                url: '/consultajax',
                async: false,


                data: {
                    "clave_cct": value
                },

                success: function(data) {

                    console.log(data);
                    carreras.find('option').remove();

                    $(data).each(function(i, v) { // indice, valor
                        carreras.append('<option value="' + v.rvoe + '" value2="' + v.vigencia + '">' + v.nombre_plan + ' ' + v.vigencia + '</option>');
                    })

                }

            });
            //carreras.on('change', fun);
            //carreras.trigger('change');
            $('#fk_rvoe').trigger('change');
        });


    });

    //segundo AJAX
    // var fun = function() {

    //funcion de select
    //segundo AJAX
    // var fun = function() {

    //funcion de select
    $(document).on('change', '#fk_rvoe', function() {
        //detectamos el evento change
        var value = $(this).val(); //sacamos el valor del select
        var value2 = $(this).find("option:selected")
            .attr("value2");
        var input = $('#input');
        // console.log("valor 2: " +value2);
        var periodos = $('#tipo_periodo');
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });
        $.ajax({

            type: 'POST',

            url: '/consultajax2',
            //  async: false,

            data: {
                "rvoe": value,
                "vigencia": value2
            },

            success: function(data) {

                console.log(data);

                periodos.find('option').remove();
                input.find('input').remove();
                $(data).each(function(i, v) { // indice, valor
                    periodos.append('<option value="' + v.id_duracion + '">' + v.nombre_duracion + '</option>');
                    input.append('<input type="text" name="vigencia" id="vigencia" value="' + v.vigencia + '" style="visibility: hidden;" >');
                })

            }

        });
    });
</script>

@endsection