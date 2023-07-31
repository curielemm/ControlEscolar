@extends('layouts.app')
<title>Lista de Docentes</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <center>
                <h3>{{$institucion->nombre_institucion}}</h3>
            </center>
            <h3 class="text-center">LISTA DE DOCENTES </h3>
            <div class="card-header">
                <h4>Busqueda del Docente </h4>
                {{ Form::open(['', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('rfc', null,['class'=>'form-control','placeholder'=>'RFC'])}}

                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
                {{Form::close() }}

            </div>
            @if(session()->has('message1'))
            <div class="alert alert-success">
                {{ session()->get('message1') }}
            </div>
            @endif
            <div class="card-body">
                <div class="form-inline pull-right">
                    <form method="get" action="{{'/agregarDocente'}}">
                        <button type="submit" class=" btn btn-primary"><span class="fa fa-plus" aria-hidden="true"> Agregar Docente</span>
                    </form>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true"> Regresar a Panel </span>
                    </form>
                </div>

                <table class="table table-light table-hover table-striped ">
                    <thead class="thead-light">
                        <tr>
                            <th>RFC</th>
                            <th>Nombre(s)</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>

                        @foreach($docentes as $docente)
                        <td>{{$docente->rfc}}</td>
                        <td>{{$docente->nombre}}</td>
                        <td>{{$docente->apellido_paterno}}</td>
                        <td>{{$docente->apellido_materno}}</td>
                        <td>{{$docente->correo}}</td>
                        <td>{{$docente->telefono}}</td>
                        <td>
                          
                            <div class="form-group row">
                      <div class="col-md-5">
                        <form action="{{route('eliminarDocente',[$docente->rfc,$clave_cct])}}" method="get">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-outline-warning"><i class="fa fa-pencil-square" aria-hidden="true"></i>
                          </button>
                        </form>
                      </div>
                      <div class="col-md-5">
                        <form action="{{route('eliminarDocente',[$docente->rfc,$clave_cct])}}" method="get">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                          </button>
                        </form>
                      </div >
                    </div>
                        </td>
                        </tr>
                        @endforeach
                </table>
                {{$docentes->render()}}
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                </thead>

            </div>

        </div>
    </div>
</div>

@endsection