@extends('layouts.app')
<title>Instituciones</title>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-ms-9">
            <div class="col-ms-12 offset-ms-12">
                <div class="card card-default">
                    <h3 class="text-center">Instituciones</h3>
                    <div class="card-body">
                        <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                        <table class="table table-light table-hover table-striped table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Turnos</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos as $institucioness)
                                <tr>

                                    <td>{{$institucioness->id_turno}}</td>
                                    <td>
                                    {{$institucioness->nombre_turno}}
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
