@extends('layouts.app')
<title>Lista de Planes Institucion</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h4>PLANES DE ESTUDIO DE {{$uno->nombre_institucion}}</h4>
            <div class="card-body">
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>

                @if($nivel == 1)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Licenciatura, Maestría, Doctorado</th>
                            <th>RVOE</th>
                            <th>Fecha de RVOE</th>
                            <th>Fecha de Publicación en el Periódico Oficial</th>
                            <th>Ver DOF</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="detallePControl/{{$planes->rvoe}}">{{$planes->nombre_plan}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->fecha_rvoe}}</td>
                            <td>{{$planes->fecha_pub_periodico}}</td>
                            @if($planes->dof != null)
                            <td class="text-center"><a href="{{Storage::url($planes->dof)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->dof == null)
                            <td class="text-center"><i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </td>
                            @endif
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
                            <th>Tipo de Bachillerato</th>
                            <th>Rvoe</th>
                            <th>Descripcion</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="perfilPlan/{{$planes->rvoe}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->descripcion}}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if($nivel==3)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tipo de Capacitación Para El Trabajo</th>
                            <th>Rvoe</th>
                            <th>Descripcion</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="perfilPlan/{{$planes->rvoe}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
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