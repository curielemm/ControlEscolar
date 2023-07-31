@extends('layouts.app')
<title>Institucion</title>
@section('content')
<div class="container">
    <div class="col-ms-9">
        <div class="card card-default">
            <h3 class="text-center">{{$uno->nombre_institucion}}</h3>
            <div class="card-body">
                <form action="{{ route('updateInstitucion',$uno->clave_cct)}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="clave_cct" class="col-sm-2 col-form-label">Clave CCT:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="clave_cct" name="clave_cct" value="{{$uno->clave_cct}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre_institucion" class="col-sm-2 col-form-label">Nombre Institución:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombre_institucion" max="80" min="5" name="nombre_institucion" value="{{$uno->nombre_institucion}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="clave_dgpi" class="col-sm-2 col-form-label">DGP</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="8" minlength="8" min="8" max="8" class="form-control" id="clave_dgpi" name="clave_dgpi" value="{{$uno->clave_dgpi}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="codigo_postal" class="col-sm-2 col-form-label">Código Postal:</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="5" minlength="5" min="5" max="5" class="form-control" onchange="getDirecciones()" id="codigo_postal" name="codigo_postal" value="{{$uno->codigo_postal}}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="municipio" class="col-sm-2 col-form-label">Municipio:</label>
                        <div class="col-sm-10">
                            <select id="municipio" name="municipio" class="form-control" disabled>
                                <option value="{{$uno->municipio}}">{{$uno->municipio}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="colonia" class="col-sm-2 col-form-label">Colonia:</label>
                        <div class="col-sm-10">
                            <select id="colonia" name="colonia" class="form-control" disabled>
                                <option value="{{$uno->colonia}}">{{$uno->colonia}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_revoe" class="col-sm-2 col-form-label">Calle:</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="25" minlength="3" class="form-control" id="calle" name="calle" value="{{$uno->calle}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_revoe" class="col-sm-2 col-form-label">Número Exterior:</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="8" minlength="0" class="form-control" id="numero_exterior" name="numero_exterior" value="{{$uno->numero_exterior}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_revoe" class="col-sm-2 col-form-label">Número Interior:</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="8" minlength="0" class="form-control" id="numero_interior" name="numero_interior" value="{{$uno->numero_interior}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_revoe" class="col-sm-2 col-form-label">Teléfono :</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="10" minlength="8" class="form-control" id="telefono" name="telefono" value="{{$uno->telefono}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_revoe" class="col-sm-2 col-form-label">Correo</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="correo" name="correo" value="{{$uno->correo}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pagina_web" class="col-sm-2 col-form-label">Fecha de Página Web</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="50" minlength="0" class="form-control" id="pagina_web" name="pagina_web" value="{{$uno->pagina_web}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Director" class="col-sm-2 col-form-label">Director</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="clave_director" name="clave_director" value="{{$uno->nombre_pila}}" disabled>
                        </div>
                    </div>



                    <center>
                        <div class="col-sm-10">
                            <button type="submit" class=" btn-success">Actualizar</button>
                        </div>
                </form>
                <br>
                <div class="col-sm-2">
                    <form action="{{route('listarInstitucion')}}" method="get">
                        <button type="submit" class=" btn btn-danger btn-block">Cancelar</button>
                    </form>
                </div>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection
