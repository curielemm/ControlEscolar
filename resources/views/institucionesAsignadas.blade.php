@extends('layouts.app')
<title>Instituciones Asignadas</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Instituciones Asignadas a {{$uno->nombre_usuario}} {{$uno->apellido_paterno}} {{$uno->apellido_materno}} </h3>
            <div class="card-body">
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <table class="table table-light table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre de la Institución <button name="info" id="info" class="btn btn-outline-primary" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                                <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto">Ayuda</strong>
                                        <small class="text-muted">cerrar</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        Al dar Clic sobre este icono <i class="fa fa-trash" aria-hidden="true"></i> puedes desvincular a la institución del analista
                                    </div>
                                </div>
                            </th>
                            <th>Clave de Centro de Trabajo</th>
                            <th>Direccion</th>
                            <th>Acciones</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $datitos)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$datitos->nombre_institucion}}
                            </td>
                            <td>{{$datitos->clave_cct}}</td>
                            <td>Municipio: {{$datitos->municipio}}, Col.{{$datitos->colonia}}, Calle:{{$datitos->calle}},
                                Num Ext:{{$datitos->numero_exterior}}, Num. Int:{{$datitos->numero_interior}}, Cp:{{$datitos->codigo_postal}}
                            </td>
                            <td>
                                <form action="{{route('borrarInstitucionAsignada')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" id="clave_usuario" name="clave_usuario" style="display:none" value="{{$uno->clave_usuario}}">
                                    <input type="hidden" id="clave_cct" name="clave_cct" style="display:none" value="{{$datitos->clave_cct}}">
                                    <button data-title="Desvincular Institucion de Analista" type="submit" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$datos->render()}}
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
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