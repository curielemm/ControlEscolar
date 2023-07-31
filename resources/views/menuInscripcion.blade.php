@extends('layouts.app')
<title>Menu Inscripcion</title>
<!--script src="//code.jquery.com/jquery-1.11.1.min.js"></script -->
<script data-require="jquery@2.2.4" data-semver="2.2.4" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
  #resultado {
    background-color: red;
    color: white;
    font-weight: bold;
  }

  #resultado.ok {
    background-color: green;
  }
  #resultado2 {
    background-color: red;
    color: white;
    font-weight: bold;
  }

  #resultado2.ok {
    background-color: green;
  }
</style>

@section('content')

<div class="container">

  <div class="row justify-content-center">

    <div class="col-md-12">

      <div class="card">
        <div>
          <form method="get" action="{{'/panel'}}">
            <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span></button>
          </form>
        </div>
        @if(session()->has('message'))
        <div class="alert alert-success">
          {{ session()->get('message') }}
        </div>
        @endif
        @if(session()->has('message1'))
        <div class="alert alert-danger">
          {{ session()->get('message1') }}
        </div>
        @endif
        <ul class="nav nav-tabs" id="myTab" role="tablist">

          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Inscribir Alumnos de Nuevo Ingreso</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="eq-tab" data-toggle="tab" href="#eq" role="tab" aria-controls="eq" aria-selected="false">Inscribir Alumno de Equivalencias</a>
          </li>
          <!--li class="nav-item">
            <a class="nav-link" id="rev-tab" data-toggle="tab" href="#rev" role="tab" aria-controls="rev" aria-selected="false">Inscribir Alumno de Revalidacion</a>
          </li-->



        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card-header">{{ __('Inscribir Alumno de Nuevo Ingreso') }}
              <div class="col-sm-10">
                <form method="get" action="{{route('formExcel',[$datos->rvoe, $datos->vigencia])}}">
                  <button type="submit" class=" btn btn btn-success"><span class="fa fa-file-excel-o" aria-hidden="true"> Cargar Datos Excel (.csv )</span>
                </form>
              </div>
            </div>
            <div class="card-heading">
              <center>
                <h4>INGRESE LOS DATOS DEL ALUMNO(A) A @if($datos->id_nivel_educativo==3){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
                  @if($datos->id_nivel_educativo!=1){{$datos->nombre_nivel_educativo}} @endif</h4>

                <h5><label class="text-danger">*</label> Campos Obligatorios</h5>

              </center>
            </div>
            <div class="card-body">
              <form action="{{ route('registroAlumnos',[encrypt($datos->rvoe), encrypt($datos->vigencia)])}}" method="post">
                {{csrf_field()}}
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> CURP:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" minlenght="18" maxlength="18" placeholder="Ingrese la CURP del Alumno" name="curp" oninput="validarInput(this)" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    {!! $errors->first('curp','<small class="text-danger">:message</small><br>') !!}
                    <pre id="resultado"></pre>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matrícula:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="15" placeholder="Ingrese la Matrícula del Alumno" name="matricula">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Nombre:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="50" placeholder="Ingrese el Nombre del Alumno" name="nombre" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('nombre','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Apellido Paterno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido paterno del alumno" name="apellido_paterno" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('apellido_paterno','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label>Apellido Materno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido materno del alumno" name="apellido_materno"  pattern="[A-Za-z ñ .]+">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Sexo:</label>
                  <div class="col-sm-9">

                    <select name="sexo" required class="form-control">
                      <option value="">SELECCIONE</option>
                      <option value="H">HOMBRE</option>
                      <option value="M">MUJER</option>
                    </select>
                    {!! $errors->first('sexo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Correo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el Correo" name="correo">
                    {!! $errors->first('correo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Teléfono:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el Teléfono (10 digitos)" name="telefono" pattern="[0-9]+">
                    {!! $errors->first('telefono','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Grupo:</label>
                  <div class="col-sm-9">
                    <select id="clave_grupo" title="option" name="clave_grupo" class="form-control">
                      @foreach($grupos as $g)
                      <option id="opciones" class="form-control" value="{{$g['clave_grupo']}}">
                        {{$g['no_periodo'] }} {{$g['nombre_grupo']}}
                      </option>@endforeach
                      <option hidden selected>Selecciona una opción</option>
                    </select>
                    {!! $errors->first('clave_grupo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Documentos Presentados:</label>
                  <div class="col-sm-9">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="acta_nacimiento" name="acta_nacimiento" value="1">Acta de Nacimiento
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="curpt" name="curpt" value="1">CURP
                      </label>
                    </div>
                    @if($datos->id_nivel_educativo==3)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_bachillerato" name="certificado_bachillerato" value="1">Certificado Bachillerato
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==4 or $datos->id_nivel_educativo==5 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_lic" name="certificado_lic"> value="1">Certificado Licenciatura
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo" name="titulo"> value="1">Titulo / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula" name="cedula" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==6 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_ma" name="certificado_ma"> value="1">Certificado Maestria
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo_ma" name="titulo_ma"> value="1">Titulo Maestria / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula_ma" name="cedula_ma" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo == 1 or $datos->id_nivel_educativo == 2 or $datos->id_nivel_educativo == 7 or $datos->id_nivel_educativo == 8 or $datos->id_nivel_educativo == 9 or $datos->id_nivel_educativo == 10)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                      </label>
                    </div>
                    @endif

                  </div>

                </div>


                <center>
                  <div class="col-sm-10">

                    <button type="submit" id="agregar1" name="agregar1" class=" btn btn-success">Agregar Alumno(a)</button>
                  </div>
                </center>
              </form>
              <center>

              </center>
            </div>
          </div>
          <div class="tab-pane fade" id="eq" role="tabpanel" aria-labelledby="eq-tab">
            <div class="card-header">{{ __('Alumno de Equivalencias') }}</div>
            <div class="card-heading">
              <center>
                <h4>INGRESE LOS DATOS DEL ALUMNO(A) DE EQUIVALENCIAS A @if($datos->id_nivel_educativo==3){{$datos->nombre_plan}} @endif
                  @if($datos->id_nivel_educativo!=1){{$datos->nombre_nivel_educativo}} @endif</h4>
                <h5><label class="text-danger">*</label> Campos Obligatorios</h5>
            </div>

            </center>
            <div class="card-body">
              <form action="{{ route('registroAlumnoEqu',[encrypt($datos->rvoe), encrypt($datos->vigencia)])}}" method="post">
                {{csrf_field()}}
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> CURP:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" minlenght="18" maxlength="18" placeholder="Ingrese la CURP del Alumno" name="curp" oninput="validarInput2(this)" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    {!! $errors->first('curp','<small class="text-danger">:message</small><br>') !!}
                    <pre id="resultado2"></pre>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matrícula:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="15" placeholder="Ingrese la Matrícula del Alumno" name="matricula">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Folio Equivalencia:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" minlength="15" maxlength="16" placeholder="Ingrese el folio de equivalencia" name="folio_equivalencia" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Nombre:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="50" placeholder="Ingrese el Nombre del Alumno" name="nombre" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('nombre','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Apellido Paterno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido paterno del alumno" name="apellido_paterno" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('apellido_paterno','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label>Apellido Materno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido materno del alumno" name="apellido_materno"  pattern="[A-Za-z ñ .]+">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Sexo:</label>
                  <div class="col-sm-9">

                    <select name="sexo" required class="form-control">
                      <option value="">SELECCIONE</option>
                      <option value="H">HOMBRE</option>
                      <option value="M">MUJER</option>
                    </select>
                    {!! $errors->first('sexo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Correo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el Correo" name="correo">
                    {!! $errors->first('correo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Teléfono:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el Teléfono (10 digitos)" name="telefono" pattern="[0-9]+">
                    {!! $errors->first('telefono','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Grupo:</label>
                  <div class="col-sm-9">
                    <select id="clave_grupo" title="option" name="clave_grupo" class="form-control">
                      @foreach($grupos2 as $g)
                      <option id="opciones" class="form-control" value="{{$g['clave_grupo']}}">
                        {{$g['no_periodo'] }} {{$g['nombre_grupo']}}
                      </option>@endforeach
                      <option hidden selected>Selecciona una opción</option>
                    </select>
                    {!! $errors->first('clave_grupo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Documentos Presentados:</label>
                  <div class="col-sm-9">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="acta_nacimiento" name="acta_nacimiento" value="1">Acta de Nacimiento
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="curpt" name="curpt" value="1">CURP
                      </label>
                    </div>
                    @if($datos->id_nivel_educativo==3)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_bachillerato" name="certificado_bachillerato" value="1">Certificado Bachillerato
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_parcial" name="certificado_parcial" value="1">Certificado Parcial
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="equivalencia" name="equivalencia" value="1">Equivalencia de Estudios
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==4 or $datos->id_nivel_educativo==5 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_lic" name="certificado_lic"> value="1">Certificado Licenciatura
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo" name="titulo"> value="1">Titulo / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula" name="cedula" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==6 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_ma" name="certificado_ma"> value="1">Certificado Maestria
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo_ma" name="titulo_ma"> value="1">Titulo Maestria / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula_ma" name="cedula_ma" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo == 1 or $datos->id_nivel_educativo == 2 or $datos->id_nivel_educativo == 7 or $datos->id_nivel_educativo == 8 or $datos->id_nivel_educativo == 9 or $datos->id_nivel_educativo == 10)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                      </label>
                    </div>
                    @endif

                  </div>

                </div>


                <center>
                  <div class="col-sm-10">

                    <button type="submit" id="agregar2" name="agregar2" class=" btn btn-success">Agregar Alumno(a)</button>
                  </div>
                </center>
              </form>
              <center>

              </center>

            </div>
          </div>
          <div class="tab-pane fade" id="rev" role="tabpanel" aria-labelledby="rev-tab">
            <div class="card-header">{{ __('Alumno de Revalidación') }}</div>
            <div class="card-heading">
              <center>
                <h4>INGRESE LOS DATOS DEL ALUMNO(A) DE REVALIDACIÓN A @if($datos->id_nivel_educativo==3){{$datos->nombre_plan}} @endif
                  @if($datos->id_nivel_educativo!=1){{$datos->nombre_nivel_educativo}} @endif</h4>
                <h5><label class="text-danger">*</label> Campos Obligatorios</h5>
            </div>

            </center>
            <div class="card-body">
              <form action="{{ route('registroAlumnos',[encrypt($datos->rvoe), encrypt($datos->vigencia)])}}" method="post">
                {{csrf_field()}}
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> CURP:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" minlenght="18" maxlength="18" placeholder="Ingrese la CURP del Alumno" name="curp" oninput="validarInput(this)" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    {!! $errors->first('curp','<small class="text-danger">:message</small><br>') !!}
                    <pre id="resultado"></pre>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matrícula:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="15" placeholder="Ingrese la Matrícula del Alumno" name="matricula">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Folio Revalidación:</label>
                  <div class="col-sm-9">
                    <input type="number"  class="form-control" min="0000000000000000" minlenght="16" maxlength="16" placeholder="Ingrese el folio de equivalencia" name="folio_equivalencia" required>
                    {!! $errors->first('curp','<small class="text-danger">:message</small><br>') !!}
                    <pre id="resultado"></pre>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Nombre:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="50" placeholder="Ingrese el Nombre del Alumno" name="nombre" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('nombre','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Apellido Paterno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido paterno del alumno" name="apellido_paterno" required pattern="[A-Za-z ñ]+">
                    {!! $errors->first('apellido_paterno','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label>Apellido Materno:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido materno del alumno" name="apellido_materno" required pattern="[A-Za-z ñ .]+">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Sexo:</label>
                  <div class="col-sm-9">

                    <select name="sexo" required class="form-control">
                      <option value="">SELECCIONE</option>
                      <option value="H">HOMBRE</option>
                      <option value="M">MUJER</option>
                    </select>
                    {!! $errors->first('sexo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Correo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el Correo" name="correo">
                    {!! $errors->first('correo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Teléfono:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el Teléfono (10 digitos)" name="telefono" pattern="[0-9]+">
                    {!! $errors->first('telefono','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Grupo:</label>
                  <div class="col-sm-9">
                    <select id="clave_grupo" title="option" name="clave_grupo" class="form-control">
                      @foreach($grupos2 as $g)
                      <option id="opciones" class="form-control" value="{{$g['clave_grupo']}}">
                        {{$g['no_periodo'] }} {{$g['nombre_grupo']}}
                      </option>@endforeach
                      <option hidden selected>Selecciona una opción</option>
                    </select>
                    {!! $errors->first('clave_grupo','<small class="text-danger">:message</small><br>') !!}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><label class="text-danger">*</label> Documentos Presentados:</label>
                  <div class="col-sm-9">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="acta_nacimiento" name="acta_nacimiento" value="1">Acta de Nacimiento/Documento Migratorio
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="curpt" name="curpt" value="1">CURP
                      </label>
                    </div>
                    @if($datos->id_nivel_educativo==3)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_parcial" name="certificado_parcial" value="1">Certificado Ó Diploma
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="equivalencia" name="equivalencia" value="1">Revalidacion de Estudios
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==4 or $datos->id_nivel_educativo==5 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_lic" name="certificado_lic"> value="1">Certificado Licenciatura
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo" name="titulo"> value="1">Titulo / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula" name="cedula" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo==6 )
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="certificado_ma" name="certificado_ma"> value="1">Certificado Maestria
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="titulo_ma" name="titulo_ma"> value="1">Titulo Maestria / Acta Examen Prof
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="cedula_ma" name="cedula_ma" value="1">Cedula
                      </label>
                    </div>
                    @endif
                    @if($datos->id_nivel_educativo == 1 or $datos->id_nivel_educativo == 2 or $datos->id_nivel_educativo == 7 or $datos->id_nivel_educativo == 8 or $datos->id_nivel_educativo == 9 or $datos->id_nivel_educativo == 10)
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" id="certificado_secundaria" name="certificado_secundaria">Certificado Secundaria
                      </label>
                    </div>
                    @endif

                  </div>

                </div>


                <center>
                  <div class="col-sm-10">

                    <button type="submit" id="agregar1" name="agregar1" class=" btn btn-success">Agregar Alumno(a)</button>
                  </div>
                </center>
              </form>
              <center>

              </center>

            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection

<script>
  function validarInput(input) {
    var curp = input.value.toUpperCase(),
      resultado = document.getElementById("resultado"),
      valido = "No válido";

    if (curpValida(curp)) {
      valido = "Válido";
      $("#agregar1").prop("disabled", false);
      console.log("valido");
      resultado.classList.add("ok");

    } else {
      $("#agregar1").prop("disabled", true);
      resultado.classList.remove("ok");
      console.log("invalido");

    }

    resultado.innerText = "CURP: " + curp + "\nFormato: " + valido;
  }

  function validarInput2(input){
    var curp = input.value.toUpperCase(),
      resultado = document.getElementById("resultado2"),
      valido = "No válido";

    if (curpValida(curp)) {
      valido = "Válido";
      $("#agregar2").prop("disabled", false);
      console.log("valido");
      resultado.classList.add("ok");

    } else {
      $("#agregar2").prop("disabled", true);
      resultado.classList.remove("ok");
      console.log("invalido");

    }

    resultado.innerText = "CURP: " + curp + "\nFormato: " + valido;
  }

  function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
      validado = curp.match(re);

    if (!validado) //Coincide con el formato general?
      return false;

    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
      //Fuente https://consultas.curp.gob.mx/CurpSP/
      var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
        lngSuma = 0.0,
        lngDigito = 0.0;
      for (var i = 0; i < 17; i++)
        lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
      lngDigito = 10 - lngSuma % 10;
      if (lngDigito == 10)
        return 0;
      return lngDigito;
    }
    if (validado[2] != digitoVerificador(validado[1]))
      return false;

    return true; //Validado
  }
</script>