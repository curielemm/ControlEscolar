@extends('layouts.app')
<title>Reportes de Instituciones</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Instituciones Nivel Superior</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="eq-tab" data-toggle="tab" href="#eq" role="tab" aria-controls="eq" aria-selected="false">Instituciones Nivel Media Superior</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rev-tab" data-toggle="tab" href="#rev" role="tab" aria-controls="rev" aria-selected="false">Instituciones de Capacitacion Para El Trabajo</a>
                    </li>



                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-header text-success">{{ __('Instituciones de Nivel Superior') }}</div>
                        <div class="card-heading">
                            <center>
                                <h4>Rellene el Formulario</h4>

                                <h5>* Campos Obligatorios</h5>

                            </center>
                        </div>
                        <div class="card-body">
                            <form action="{{route('reportePDF')}}" method="post">
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
                                    <label class="col-sm-2 col-form-label">* Ciclo Escolar:</label>
                                    <div class="col-sm-9">
                                        <select id="id_ciclo_escolar" title="option" name="id_ciclo_escolar" class="form-control">
                                            @foreach($ciclo as $g)
                                            <option id="opciones" class="form-control" value="{{$g['id_ciclo_escolar']}}">
                                                {{$g['id_ciclo_escolar']}}
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
                    </div>
                    <div class="tab-pane fade" id="eq" role="tabpanel" aria-labelledby="eq-tab">
                        <div class="card-header">{{ __('Institución de Nivel Media Superior') }}</div>
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
                                            <label class="col-sm-2 col-form-label">* Ciclo Escolar:</label>
                                            <div class="col-sm-9">
                                                <select id="id_ciclo_escolar" title="option" name="id_ciclo_escolar" class="form-control">
                                                    @foreach($ciclo as $g)
                                                    <option id="opciones" class="form-control" value="{{$g['id_ciclo_escolar']}}">
                                                        {{$g['id_ciclo_escolar']}}
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
                        <div class="card-header">{{ __('Instituciones de Capacitacion para el Trabajo') }}</div>
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

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Ciclo Escolar:</label>
                                    <div class="col-sm-9">
                                        <select id="id_ciclo_escolar" title="option" name="id_ciclo_escolar" class="form-control">
                                            @foreach($ciclo as $g)
                                            <option id="opciones" class="form-control" value="{{$g['id_ciclo_escolar']}}">
                                                {{$g['id_ciclo_escolar']}}
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
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
