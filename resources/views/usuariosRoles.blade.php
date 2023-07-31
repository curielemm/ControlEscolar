@extends('layouts.app')
<title>Roles de Usuarios</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <div class="card-body">
                <a href="{{'/dashboard'}}">Regresar al Panel de Control</a>
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
                            <th>Roles</th>
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
                            <td>{{$usuarios->institucion}}</td>
                            <td>{{$usuarios->puesto}}</td>
                            <td>
                                @if($usuarios->role_id==1)
                                <form action="{{ route('cambiarRole',$usuarios->clave_usuario)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="1" checked>Administrador</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="2">Analista</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="3">Control Escolar</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="0">Ninguno</label>
                                    </div>
                                    @if(Auth::user()->clave_usuario==$usuarios->clave_usuario)
                                    <button type="submit" class=" btn btn-danger" onclick="return confirm('¿Guardar Cambios?')"disabled>Guardar Cambios</button>
                                    @endif
                                    @if(Auth::user()->clave_usuario!=$usuarios->clave_usuario)
                                    <button type="submit" class=" btn btn-danger" onclick="return confirm('¿Guardar Cambios?')">Guardar Cambios</button>
                                    @endif
                                </form>
                                @endif
                                @if($usuarios->role_id==2)
                                <form action="{{ route('cambiarRole',$usuarios->clave_usuario)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="1">Administrador</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" checked value="2">Analista</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="3">Control Escolar</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="0">Ninguno</label>
                                    </div>
                                    <button type="submit" class=" btn btn-danger" onclick="return confirm('¿Guardar Cambios?')" >Guardar Cambios</button>
                                </form>
                                @endif
                                @if($usuarios->role_id==3)
                                <form action="{{ route('cambiarRole',$usuarios->clave_usuario)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="1">Administrador</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="2">Analista</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" checked value="3">Control Escolar</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="0">Ninguno</label>
                                    </div>
                                    <button type="submit" class=" btn btn-danger" onclick="return confirm('¿Guardar Cambios?')">Guardar Cambios</button>
                                </form>
                                @endif
                                @if($usuarios->role_id==null || $usuarios->role_id==0)
                                <form action="{{ route('cambiarRole',$usuarios->clave_usuario)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="1">Administrador</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="2">Analista</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" value="3">Control Escolar</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" checked value="0">Ninguno</label>
                                    </div>
                                    <button type="submit" class=" btn btn-danger" onclick="return confirm('¿Guardar Cambios?')">Guardar Cambios</button>
                                </form>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    </thead>
                </table>
                {{$datos->render()}}
                <a href="{{'/dashboard'}}">Regresar al Panel de Control</a>
            </div>
        </div>
    </div>
</div>

@endsection
