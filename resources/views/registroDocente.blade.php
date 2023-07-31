@extends('layouts.app')
<title>Agregar Docente</title>
@section('content')

<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card card-default">
      @if(session()->has('message1'))
      <div class="alert alert-success">
        {{ session()->get('message1') }}
      </div>
      @endif
      @if(session()->has('message2'))
      <div class="alert alert-danger">
        {{ session()->get('message2') }}
      </div>
      @endif
      <div class="card-heading">
        <br>
        <center>
          <h4>{{$institucion->nombre_institucion}}</h4>
          <h5>INGRESE LOS DATOS DEL DOCENTE </h5>

          <h6>* Campos Obligatorios</h6>
          <center>
      </div>
      <div class="card-body">
        <form action="{{ route('insertarDocente')}}" method="post">
          {{csrf_field()}}
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* RFC:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" minlenght="18" value="{{old('rfc')}}" maxlength="18" placeholder="Ingrese el RFC del Docente" name="rfc" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
              {!! $errors->first('rfc','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Nombre:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="50" value="{{old('nombre')}}" placeholder="Ingrese el Nombre del Docente" name="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ]+">
              {!! $errors->first('nombre','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Apellido Paterno:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="30" value="{{old('apellido_paterno')}}" placeholder="Ingrese el apellido paterno del Docente" name="apellido_paterno" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ]+">
              {!! $errors->first('apellido_materno','<small class="text-danger">:message</small><br>') !!}

            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">*Apellido Materno:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="30" value="{{old('apellido_materno')}}" placeholder="Ingrese el apellido materno del Docente" name="apellido_materno" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[A-Za-z ñ .]+">
              {!! $errors->first('apellido_materno','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>


          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Correo:</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" maxlength="30" value="{{old('correo')}}" placeholder="Ingrese el Correo" name="correo" required>
              {!! $errors->first('correo','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" maxlength="10" value="{{old('telefono')}}" placeholder="Ingrese el Teléfono (10 digitos)" name="telefono" pattern="[0-9]+" required>
              {!! $errors->first('telefono','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>
          <center>
            <div class="col-sm-10">
              <button type="submit" class=" btn btn-success">Agregar Docente</button>
            </div>
          </center>
        </form>

      </div>

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

</div>


@endsection