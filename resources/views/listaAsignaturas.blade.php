@extends('layouts.app')
<title>Lista de asignaturas </title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Asignaturas de la Carrera {{$uno->nombre_plan}}</h3>
            <div class="card-body">
                <a href="{{'/dashboard'}}">Regresar al Panel de Control</a>
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Asignatura</th>
                            <th>Clave Asignatura</th>
                            <th>Creditos</th>
                            <th>Serialización</th>
                            <th>Tipo asignatura</th>
                            <th>Semestre-Cuatrimestre</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $asignaturas)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="">{{$asignaturas->nombre_asignatura}}</a></td>
                            <td>{{$asignaturas->clave_asignatura}}</td>
                            <td>{{$asignaturas->no_creditos}}</td>
                            <td>{{$asignaturas->seriazion}}</td>
                            <td>{{$asignaturas->tipo_asignatura}}</td>
                            <td>{{$asignaturas->semestre_cuatrimestre}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$datos->render()}}
                <a href="{{'/dashboard'}}">Regresar al Panel de Control</a>
            </div>
        </div>
        <a class="btn btn-danger" href="/pdf/{{$uno->clave_cct}}">Generar Ficha Tecnica</a>
        <a class="btn btn-danger" href="/vistaFichaTec/{{$uno->clave_cct}}">Ver Ficha Tecnica</a>

    </div>

</div>

@endsection
