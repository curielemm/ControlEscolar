@extends('layouts.app')
<title>Detalle del Plan</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
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
            <h4>{{$institucion->nombre_institucion}}</h4>
            <h3>Actualizaciones del Plan {{$plan->nombre_plan}} RVOE: {{$plan->rvoe}}</h3>
            <div class="card-body">
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>

                @if($nivel == 1)
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Licenciatura, Maestría, Doctorado</th>
                            <th>Rvoe</th>
                            <th>Clave de Plan</th>
                            <th>Vigencia</th>
                            <th>Ver Plan de Estudio</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <a href="{{route('perfilPlan',[encrypt($planes->rvoe),encrypt($planes->vigencia)])}}">{{$planes->nombre_plan}}</a>
                            </td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->clave_plan}}</td>
                            <td>{{$planes->vigencia}}</td>
                            @if($planes->archivo != null)
                            <td class="text-center"><a href="{{Storage::url($planes->archivo)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            @endif
                            @if($planes->archivo == null)
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
                            <th>Vigencia</th>
                            <th>Descripcion</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="perfilPlan/{{$planes->rvoe}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->vigencia}}</td>
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
                            <th>Vigencia</th>
                            <th>Descripcion</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $planes)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="perfilPlan/{{$planes->rvoe}}">{{$planes->nombre_nivel_educativo}}</a></td>
                            <td>{{$planes->rvoe}}</td>
                            <td>{{$planes->vigencia}}</td>
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