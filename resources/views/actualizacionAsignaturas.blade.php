@extends('layouts.app')
<title>Actualizar Asignaturas</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">
            <h3 class="text-center"> {{$institucion->nombre_institucion}} </h3>
            <h3 class="text-center">Actualización de Asignaturas del Plan de Estudios:</h3>
            <h4 class="text-center">{{$plan->nombre_plan}} Vigencia: {{$plan->vigencia}}</h4>
            <div class="card">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Cambio Parcial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="eq-tab" data-toggle="tab" href="#eq" role="tab" aria-controls="eq" aria-selected="false">Cambio Total</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-header">{{ __('Cambio Parcial de Asignaturas') }}</div>
                        <div class="card-heading">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Clave Asignatura</th>
                                        <th>Nombre Asignatura</th>
                                        <th>No. Créditos</th>
                                        <th>Seriación</th>
                                        <th>Tipo Asignatura</th>
                                        <th>No. Parciales</th>
                                        <th>No. Período</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materias as $materia)

                                    <tr>
                                        <form action="" method="post">
                                            {{csrf_field()}}
                                            <td> <input type="text" value="{{$materia->clave_asignatura}}"> </td>
                                            <td> <input type="text" value="{{$materia->nombre_asignatura}}"></td>
                                            <td> <input type="text" value="{{$materia->no_creditos}}"></td>
                                            <td> <input type="text" value="{{$materia->seriacion}}"></td>
                                            <td> <input type="text" value="{{$materia->tipo_asignatura}}"></td>
                                            <td> <input type="text" value="{{$materia->no_parciales}}"></td>
                                            <td> <input type="text" value="{{$materia->no_periodo}}"></td>

                                            <td>
                                                <div>
                                                    <button type="submit" class=" btn-success btn-block">Cambiar</button>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        {{$materias->render()}}
                        <div class="card-body">

                        </div>
                    </div>

                    <div class="tab-pane fade" id="eq" role="tabpanel" aria-labelledby="eq-tab">
                        <div class="card-header">{{ __('Cambio Total de Asignaturas') }}</div>
                        <div class="card-heading">
                            <center>
                                <h4>Rellene el Formulario</h4>

                                <h5>* Campos Obligatorios</h5>
                                <div class="card-body">

                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection