@extends('layouts.app')
<title>Usuarios de Control Escolar</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Usuarios de Control Escolar</h3>
            <div class="card-header">
                <h4>Búsqueda de Usuarios de Control Escolar</h4>
                {{ Form::open(['route'=>'listaescolar', 'method' =>'GET', 'class' => 'form-inline pull-right'])}}

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
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Clave de Usuario <button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar clic sobre el nombre el icono de <i class="fa fa-trash" aria-hidden="true"></i> puedes eliminar al usuario de Control Escolar
                                    </div>
                                </div>
                            </th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Institución</th>
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
                            <td>
                                <form action="{{ route('eliminarUsuario',$usuarios->id)}}" method="post">
                                    {{csrf_field()}}
                                    <button data-title="Eliminar Usuario de Control Escolar" type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Borrar?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                    </thead>
                </table>
                {{$datos->render()}}
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(document).on('click', '#info', function() {
            $(".toast").toast({
                autohide: true,
                delay: 500000
            });
            $('.toast').toast('show');
        });
    });
</script>
@endsection