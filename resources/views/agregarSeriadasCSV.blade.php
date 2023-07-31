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
                <div class="card-header">{{ __('Agregar Claves de Seriacion') }}

                    <div class="form-inline pull-right">

                        <a href="{{Storage::url('formato_seriacion.csv')}}" type="submit" class="btn btn-primary"><span class="fa fa-download" aria-hidden="true"> Descargar Formato</span></a>

                    </div>
                </div>
                <div class="card-heading">
                </div>
                <div class="card-body">
                    <form action="{{ route('agregarSeriadasCSV')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
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
                                <input type="text" class="form-control" value="{{$plan->vigencia}}" name="vigencia" id="vigencia" readonly required>
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

                                <button type="submit" class="btn btn-primary"> <span class="fa fa-upload" aria-hidden="true"> Cargar Seriación</span> </button>

                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection