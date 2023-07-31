<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@extends('layouts.app')
<title>Agregar Grupo</title>
@section('content')

</style>
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card card-default">
      <div class="card-heading">
        <br>
        <center>
          <h4>INGRESE LOS DATOS DEL GRUPO PARA "@if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
            @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} {{$datos->vigencia}} @endif"</h4>

          <h5><label class="text-danger">*</label> Campos Obligatorios</h5>
          @if(session()->has('message2'))
          <div class="alert alert-danger">
            {{ session()->get('message2') }}
          </div>
          @endif
          <center>
      </div>
      <div class="card-body">
        <form action="{{ route('registroGrupo',[$datos->rvoe, $datos->vigencia])}}" method="post">
          {{csrf_field()}}
          <div class="form-group row">
            <label class="col-sm-3  col-form-label"><label class="text-danger">*</label> Nombre:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{old('nombre_grupo')}}" maxlength="15" placeholder="Ingrese el nombre del Grupo" name="nombre_grupo" onkeyup="javascript:this.value=this.value.toUpperCase();">
              {!! $errors->first('nombre_grupo','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label"><label class="text-danger">*</label> N° de Periodo:</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" value="{{old('no_periodo')}}" min="1" max="12" placeholder="Ingrese el numero del Semestre/Cuatrimestre/Bimestre" name="no_periodo" onkeyup="javascript:this.value=this.value.toUpperCase();" required pattern="[0-9]+">
              {!! $errors->first('no_periodo','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label"><label class="text-danger">*</label> Periodo Escolar:</label>

            <div class="col-sm-4">
              <label><label class="text-danger">*</label> Fecha Inicio:</label>
              <input type="date" class="form-control" value="{{old('fecha_iniP')}}" onchange="pasar();" id="fecha_iniP" name="fecha_iniP">
              {!! $errors->first('fecha_iniP','<small class="text-danger">:message</small><br>') !!}
            </div>
            <div class="col-sm-4">
              <label><label class="text-danger">*</label> Fecha Fin:</label>
              <input type="date" class="form-control" value="{{old('fecha_finP')}}" id="fecha_finP" name="fecha_finP">
              {!! $errors->first('fecha_finP','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>


          <div class="form-group row">
            <label class="col-sm-3 col-form-label"><label class="text-danger">*</label> Turno:</label>
            <div class="col-sm-9">
              <select id="id_turno" title="option" name="id_turno" class="form-control">
                @foreach($turno as $t)<option id="opciones" class="form-control" value="{{$t->id_turno}}" required readonly>
                  {{$t->nombre_turno}}
                </option>@endforeach
                <option hidden selected>Selecciona una opción</option>
              </select>
              {!! $errors->first('id_turno','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"><label class="text-danger">*</label> Ciclo Escolar:</label>
            <div class="col-sm-9">
              <select id="id_ciclo_escolar" title="option" name="id_ciclo_escolar" class="form-control">
                @foreach($ciclo as $c)
                <option id="opciones" class="form-control" value="{{$c['id_ciclo_escolar']}}">
                  {{$c->id_ciclo_escolar}}
                </option>@endforeach
                <option hidden selected>Selecciona una opción</option>
              </select>{!! $errors->first('id_ciclo_escolar','<small class="text-danger">:message</small><br>') !!}
            </div>
          </div>
          <input type="hidden" name="vigencia" id="vigencia" value="{{$datos->vigencia}}">
          <center>
            <div class="col-sm-10">

              <button type="submit" class=" btn btn-success">Crear Grupo</button>
            </div>
          </center>
        </form>

      </div>

      <div class="card-body">
        <div>
          <form method="get" action="{{'/panel'}}">
            <button type="submit" class=" btn btn btn-danger"><span class="fa fa-home" aria-hidden="true">Regresar al Panel </span>
          </form>
        </div>

      </div>

    </div>


  </div>
  <script>
    function pasar() {
      var value = $("#fecha_iniP").val();
      $("#fecha_finP").attr("min", value);
    }
  </script>


  @endsection