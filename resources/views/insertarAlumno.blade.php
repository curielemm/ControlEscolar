@extends('layouts.app')
<title>Agregar Alumno(a)</title>
@section('content')

<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card card-default">
      <div class="card-heading">
        <br>
        <center>
          <h4>INGRESE LOS DATOS DEL ALUMNO(A) A @if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} @endif
            @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif</h4>

          <h5>* Campos Obligatorios</h5>
          @if(session()->has('message'))
          <div class="alert alert-success">
            {{ session()->get('message') }}
          </div>
          @endif
          <center>
      </div>
      <div class="card-body">
        <form action="{{ route('registroAlumnos',$datos->rvoe)}}" method="post">
          {{csrf_field()}}
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* CURP:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" minlenght="18" maxlength="18" placeholder="Ingrese la CURP del Alumno" name="curp" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
              {!! $errors->first('curp','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Matrícula:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="15" placeholder="Ingrese la Matrícula del Alumno" name="matricula" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Nombre:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="50" placeholder="Ingrese el Nombre del Alumno" name="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ]+">
              {!! $errors->first('nombre','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Apellido Paterno:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido paterno del alumno" name="apellido_paterno" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ]+">
              {!! $errors->first('apellido_paterno','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">*Apellido Materno:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="30" placeholder="Ingrese el apellido materno del alumno" name="apellido_materno" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ .]+">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Sexo:</label>
            <div class="col-sm-9">

              <select name="sexo" required class="form-control">
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
            <label class="col-sm-2 col-form-label">* Grupo:</label>
            <div class="col-sm-9">
              <select id="clave_grupo" title="option" name="clave_grupo" class="form-control">
                @foreach($grupos as $g)
                <option id="opciones" class="form-control" value="{{$g['clave_grupo']}}">
                  {{$g['nombre_grupo']}}
                </option>@endforeach
                <option hidden selected>Selecciona una opción</option>
              </select>
              {!! $errors->first('clave_grupo','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <center>
            <div class="col-sm-10">

              <button type="submit" class=" btn btn-success">Agregar Alumno(a)</button>
            </div>
          </center>
        </form>
      </div>

      <center>
        <div class="col-sm-10">
          <form method="get" action="{{route('formExcel',$datos->rvoe)}}">
            <button type="submit" class=" btn btn btn-success"><span class="fa fa-file-excel-o" aria-hidden="true"> Cargar Datos</span>
          </form>
        </div>
      </center>

      <tr>



        <div class="card-body">
          <div>
            <form method="get" action="{{'/panel'}}">
              <button type="submit" class=" btn btn btn-danger"><span class="fa fa-home" aria-hidden="true">Regresar al Panel </span>
            </form>
          </div>

        </div>

    </div>


  </div>



  @endsection
