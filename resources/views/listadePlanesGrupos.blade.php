@extends('layouts.app')
<title>Lista de Planes Institucion</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h4>PLANES DE ESTUDIO DE {{$uno->nombre_institucion}}</h4>
            <h4>Seleccione un plan para agregar un grupo</h4>
            <div class="card-body">
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>

                @if($nivel==1)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Licenciatura, Maestría, Doctorado</th>
                            <th>Rvoe</th>
                            <th>Clave de Plan</th>
                            <th>Descripción</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="formGroup/{{$planes->rvoe}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_plan}}</td>
                            <td>{{$planes->descripcion}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                @if($nivel==2)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Bachillerato</th>
                            <th>Rvoe</th>
                            <th>Clave de Plan</th>
                            <th>Descripción</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="formGroup/{{$planes->rvoe}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_plan}}</td>
                            <td>{{$planes->descripcion}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                {{$datos->render()}}
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
            </div>
        </div>
    </div>
</div>

@endsection
