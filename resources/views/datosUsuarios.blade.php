@extends('layouts.app')
<title>Usuarios no Autorizados</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        @if($nombrec != null)
        <div class="alert alert-primary" role="alert">
            This is a primary alert—check it out!
        </div>
        @endif
        <div class="card card-default">
            <h3 class="text-center">Autorizar Usuarios</h3>
            <div class="card-header">
                <h4>Búsqueda de usuario</h4>
                {{ Form::open(['route'=>'listarUsuario', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

                <div class="form-group mb-2">
                    {{Form::text('clave_usuario', null,['class'=>'form-control','placeholder'=>'Clave Usuario'])}}

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('nombre_usuario', null,['class'=>'form-control','placeholder'=>'Nombre Usuario'])}}

                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
                {{Form::close() }}

            </div>
            <div class="card-body">
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Clave de Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Institución</th>
                            <th>Puesto</th>
                            <th>Acciones</th>
                        </tr>
                    <tbody>
                        @foreach($datos as $usuarios)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$usuarios->clave_usuario}}</td>
                            <td>{{$usuarios->nombre_usuario}}</td>
                            <td>{{$usuarios->apellido_paterno}}</td>
                            <td>{{$usuarios->apellido_materno}}</td>
                            <td>{{$usuarios->email}}</td>
                            <td>{{$usuarios->nombre_institucion}}</td>
                            <td>{{$usuarios->descripcion}}</td>
                            <td>
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <form action="{{ route('activarUsuario',$usuarios->id)}}" method="post">
                                            {{csrf_field()}}

                                            <button data-title="Autorizar Usuario." type="submit" class="btn btn-outline-success " onclick="return confirm('¿Autorizar?')"><i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-5">
                                        <form action="{{ route('eliminarUsuario',$usuarios->id)}}" method="post">
                                            {{csrf_field()}}
                                            <button data-title="Borrar solicitud" type="submit" class="btn btn-outline-danger " onclick="return confirm('¿Borrar?')"><i class="fa fa-ban" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    </thead>
                </table>
                {{$datos->render()}}
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection