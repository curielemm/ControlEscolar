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
                @if(session()->has('message2'))
                <div class="alert alert-danger">
                    {{ session()->get('message2') }}
                </div>
                @endif
                <div class="card-header">{{ __('Agregar Asignaturas de Nivel Superior') }}</div>
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
                                <input type="text" class="form-control" value="{{$institucion->nombre_institucion}}" readonly>
                                <input type="text" name="nivel" value="1" style="visibility:hidden">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Clave de Centro de Trabajo:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{$institucion->clave_cct}}" name="clave_cct" id="clave_cct" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Nombre de la Licenciatura:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{$plan->nombre_plan}}" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* RVOE:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{$plan->rvoe}}" name="fk_rvoe" id="fk_rvoe" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Vigencia:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{$vigencia}}" name="vigencia" id="vigencia" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" value="{{$plan->id_duracion}}" name="tipo_periodo" id="tipo_periodo" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Archivo de Excel .csv</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file" id="file" accept=".csv" required>
                            </div>
                        </div>

                        <div class="form-group row" id="input" name="input">

                        </div>
                        <center>
                            <div class="col-sm-10">

                                <button type="submit" class="btn btn-primary"> <span class="fa fa-upload" aria-hidden="true"> Cargar Asignaturas</span> </button>

                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection