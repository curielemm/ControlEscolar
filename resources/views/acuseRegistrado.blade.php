@extends('layouts.login')
<title>Comprobante de Registro</title>
@section('content')
<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-danger">El documento escaneado esta registrado con los siguientes datos:</h5>
                <div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>CCT</th>
                                <th>Nombre Institucion</th>
                                <th>RVOE</th>
                                <th>Vigencia</th>
                                <th>Plan</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$institucion->clave_cct}}</td>
                                <td> {{$institucion->nombre_institucion}} </td>
                                <td>{{$plan->rvoe}}</td>
                                <td>{{$plan->vigencia}}</td>
                                <td>{{$plan->nombre_plan}}</td>
                                <td>{{$grupo->nombre_grupo}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <a type="button" class="btn btn-info" href="/">Regresar al inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection