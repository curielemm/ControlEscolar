@extends('layouts.app')
<title>ELIMINAR ALUMNO</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <div class="card-heading">
              <br>
                <center>
                    <h3>¿ESTA SEGURO DE ELIMINAR AL ALUMNO(A)?</h3>
                    <center>
            </div>
            <div class="card-body">
                <form action="{{ route('eliminar_alum/',$uno->matricula)}}" method="put">
                  {{csrf_field()}}
                      <div class="form-group row">
                          <label  class="col-sm-2 col-form-label">CURP:</label>
                          <div class="col-sm-10">
                              <input type="label" readonly class="form-control-plaintext" id="curp" name="curp" value="{{$uno->curp}}" disabled>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Matricula:</label>
                          <div class="col-sm-8">
                        <input type="label" readonly class="form-control-plaintext" id="matricula" name="matricula" value="{{$uno->matricula}}" disabled>
                          </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col-sm-8">
                                <input type="label" readonly class="form-control-plaintext" id="nombre" name="nombre" value="{{$uno->nombre}}" disabled>
                                </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2 col-form-label">Apellido Paterno:</label>
                                      <div class="col-sm-8">
                                      <input type="label" readonly class="form-control-plaintext" id="apellido_paterno" name="apellido_paterno" value="{{$uno->apellido_paterno}}" disabled>
                                      </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Apellido Materno:</label>
                                            <div class="col-sm-8">
                                      <input type="label" readonly class="form-control-plaintext" id="apellido_materno" name="apellido_materno" value="{{$uno->apellido_materno}}" disabled>
                                            </div>
                                              </div>

                                              <div class="form-group row">
                                                  <label class="col-sm-2 col-form-label">Genero:</label>
                                                  <div class="col-sm-8">
                                                  <input type="label" readonly class="form-control-plaintext" id="genero" name="genero" value="{{$uno->genero}}" disabled>
                                                  </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Correo:</label>
                                                        <div class="col-sm-8">
                                                            <input type="label" readonly class="form-control-plaintext" id="correo" name="correo" value="{{$uno->correo}}" disabled>
                                                        </div>
                                                          </div>

                                                          <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">Teléfono:</label>
                                                              <div class="col-sm-8">
                                                                <input type="label" readonly class="form-control-plaintext" id="telefono" name="telefono" value="{{$uno->telefono}}" disabled>
                                                              </div>
                                                                </div>



                        <center>
                    <div class="col-sm-3">
                        <button type="submit" class=" btn btn-success btn-block" onclick="return confirm('ELIMINAR?')">Eliminar</button>
                    </div>
                </form>
                  </center>
                <div class="col-sm-3">
                    <form action="{{route('listarAlumnos')}}" method="get">
                        <button type="submit" class="btn btn-danger btn-block">Cancelar</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
