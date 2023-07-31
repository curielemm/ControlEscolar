@extends('layouts.app')
<title>Agregar Asignaturas</title>
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
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Asignaturas de Nivel Superior</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="eq-tab" data-toggle="tab" href="#eq" role="tab" aria-controls="eq" aria-selected="false">Asignaturas de Nivel Media Superior</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rev-tab" data-toggle="tab" href="#rev" role="tab" aria-controls="rev" aria-selected="false">Asignaturas de Capacitacion para El Trabajo</a>
                    </li>



                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-header text-success">{{ __('Agregar Asignaturas de Nivel Superior') }}</div>
                        <div><a type="button" class="btn btn-success" href="/agregarCSV"><span class="fa fa-file-excel-o" aria-hidden="true"> Agregar Asignaturas con Archivo .csv</span></a></div>
                        <div class="card-heading">
                            <center>
                                <h4>Rellene el Formulario</h4>

                                <h5>* Campos Obligatorios</h5>

                            </center>
                        </div>
                        <div class="card-body">
                             <form action="{{ route('registroMateria')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nombre Institución:</label>
                                    <div class="col-sm-9">
                                        <select id="clave_cct" title="option" name="clave_cct" class="form-control">
                                            @foreach($institucionSU as $g)
                                            <option id="opciones" class="form-control" value="{{$g['clave_cct']}}">
                                                {{$g['nombre_institucion']}}
                                            </option>@endforeach
                                            <option hidden selected>Selecciona una opción</option>
                                        </select>
                                        <input type="text" name="nivel" value="1" style="visibility:hidden">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nombre de la Licenciatura:</label>
                                    <div class="col-sm-9">
                                        <select id="fk_rvoe" title="option" name="fk_rvoe" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Clave de la Asignatura:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Clave de Asignatura" name="clave_asignatura" id="clave_asignatura" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('clave_asignatura')}}" required maxlength="10">
                                        {!!$errors->first('clave_asignatura','<small class="text-danger">:message</small><br>')!!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nombre de la Asignatura:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nombre de la Asignatura" name="nombre_asignatura" id="nombre_asignatura" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('nombre_asignatura')}}" required maxlength="30">
                                        {!!$errors->first('nombre_asignatura','<small class="text-danger">:message</small><br>')!!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Tipo de Asignatura:</label>
                                    <div class="col-sm-9">
                                        <select name="tipo_asignatura" id="tipo_asignatura" class="form-control" required>
                                            <option value="SELECCIONE" selected>SELECCIONE UNA OPCIÓN</option>
                                            <option value="1">TRONCO COMÚN</option>
                                            <option value="2">ESPECIALIDAD</option>
                                        </select> {!!$errors->first('nombre_asignatura','<small class="text-danger">:message</small><br>')!!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* No Periodo:</label>
                                    <div class="col-sm-3">

                                        <input type="text" class="form-control" name="no_periodo" id="no_periodo" value="{{old('no_periodo')}}" placeholder="Numero de Periodo (1-13)">

                                    </div>
                                    <label class="col-sm-3 col-form-label">* Periodo Academico:</label>
                                    <div class="col-sm-3">
                                        <select id="semestre_cuatrimestre" title="option" name="semestre_cuatrimestre" class="form-control" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Seriación:</label>
                                    <div class="col-sm-3">

                                        <select id="seriazion" title="option" name="seriacion" class="form-control">
                                            <option hidden selected>Seriación</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-3 col-form-label">* No. Creditos:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="No. Creditos" name="no_creditos" id="no_creditos" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('no_creditos')}}" required maxlength="2">
                                        {!!$errors->first('no_creditos','<small class="text-danger">:message</small><br>')!!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Clave Seriacion:</label>
                                    <div class="col-sm-3">

                                        <input type="text" class="form-control" name="clave_seriacion" id="clave_seriacion" value="{{old('clave_seriacion')}}" placeholder="Clave de Seriazión">

                                    </div>
                                    <label class="col-sm-3 col-form-label">* No. Parciales:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="No. de Parciales" name="no_parciales" id="no_parciales" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('no_parciales')}}" required maxlength="2">

                                    </div>
                                </div>
                                <center>
                                    <div class="col-sm-10">

                                        <button type="submit" class="btn btn-primary"> Agregar Asignatura</button>

                                    </div>
                                </center>
                            </form>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="eq" role="tabpanel" aria-labelledby="eq-tab">
                        <div class="card-header">{{ __('Agregar Asignaturas de Nivel Media Superior') }}</div>
                        <div class="card-heading">
                            <center>
                                <h4>Rellene el Formulario</h4>

                                <h5>* Campos Obligatorios</h5>
                                <div class="card-body">
                                    <form action="{{route('reportePDF')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">* Nombre Institución:</label>
                                            <div class="col-sm-9">
                                                <select id="clave_cct" title="option" name="clave_cct" class="form-control">
                                                    @foreach($institucionMSU as $g)
                                                    <option id="opciones" class="form-control" value="{{$g['clave_cct']}}">
                                                        {{$g['nombre_institucion']}}
                                                    </option>@endforeach
                                                    <option hidden selected>Selecciona una opción</option>
                                                </select>
                                                <input type="text" name="nivel" value="2" style="visibility:hidden">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">* Bachillerato:</label>
                                            <div class="col-sm-9">
                                                <select id="rvoe" title="option" name="rvoe" class="form-control">
                                                    @foreach($institucionMSU as $g)
                                                    <option id="opciones" class="form-control" value="{{$g['rvoe']}}">
                                                        {{$g['nombre_nivel_educativo']}}
                                                    </option>@endforeach
                                                    <option hidden selected>Selecciona una opción</option>
                                                </select>
                                            </div>
                                        </div>


                                        <center>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary"><span class="fa fa-file-pdf-o" aria-hidden="true"> Generar Reporte</span></button>

                                            </div>
                                        </center>
                                    </form>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rev" role="tabpanel" aria-labelledby="rev-tab">
                        <div class="card-header">{{ __('Agregar Asignaturas de Capacitacion para el Trabajo') }}</div>
                        <div class="card-heading">
                            <center>
                                <h4>Rellene el Formulario</h4>

                                <h5>* Campos Obligatorios</h5>

                            </center>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nombre Institución:</label>
                                    <div class="col-sm-9">
                                        <select id="clave_cct" title="option" name="clave_cct" class="form-control">
                                            @foreach($institucionCPT as $g)
                                            <option id="opciones" class="form-control" value="{{$g['clave_cct']}}">
                                                {{$g['nombre_institucion']}}
                                            </option>@endforeach
                                            <option hidden selected>Selecciona una opción</option>
                                        </select>
                                        <input type="text" name="nivel" value="3" style="visibility:hidden">
                                    </div>
                                </div>


                                <center>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary"><span class="fa fa-file-pdf-o" aria-hidden="true"> Generar Reporte</span></button>

                                    </div>
                                </center>
                            </form>

                        </div>
                    </div>

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
            var periodos = $('#semestre_cuatrimestre');
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
                        carreras.append('<option value="' + v.rvoe + '">' + v.nombre_plan + " " + v.vigencia + '</option>');
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
    $(document).on('change', '#fk_rvoe', function() {
        //detectamos el evento change
        var value = $(this).val(); //sacamos el valor del select
        var periodos = $('#semestre_cuatrimestre');
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
                "rvoe": value
            },

            success: function(data) {

                console.log(data);

                periodos.find('option').remove();

                $(data).each(function(i, v) { // indice, valor
                    periodos.append('<option value="' + v.id_duracion + '">' + v.nombre_duracion + '</option>');

                })
            }

        });
    });
</script>
<script>
    $(function() {
        $("#no_periodo").keyup(function() {
            if ($(this).val() === "1") {
                $("#seriazion").prop("disabled", true);
                $("#clave_seriacion").prop("disabled", true);

            } else {
                $("#seriazion").prop("disabled", false);
                $("#clave_seriacion").prop("disabled", false);

            }
        });
    });
</script>
@endsection