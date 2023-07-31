@extends('layouts.app')
<title>Registro Plan</title>
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
  #asterisco {
    color: red;
  }
  #obligatorios {
    color: red;
    font-size: 18px;
    font-weight: bold;
    display: block;
    border: white;
  </style>

  <div class="row" >
    <div class="col-md-7 offset-md-2">
      <div class="card card-default">
        <div class="card-heading">
          <center>
            <h2>REGISTRO DE PLAN DE ESTUDIOS</h2>
            <h2>"CAPACITACIÓN PARA EL TRABAJO"</h2>
            <center>
            </div>

            <div class="card-body" >
              <form  action="{{ route('registroPlanesCPT')}}" method="post" id="planes" >
                @csrf
                <center><label class="control-label col-sm-11" id="obligatorios" >* Datos  obligatorios</label></center>

                <div class="container">
                  <div class="row">
                    <div class="col-xs-12 col-md-12">
                      <div class="form-group two-fields">
                        <div class="input-group">
                         <div class="col-sm-offset-2 col-sm-12">
                           <div>
                            @foreach($escuela as $e)
                            <input type="text"  class="form-control" name="nombre_institucion" value="{{$e['nombre_institucion']}}" readonly>
                            @endforeach

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>




              <div class="container">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="form-group two-fields">
                      <div class="input-group">
                        <label class="control-label col-sm-0" id="asterisco">*</label>
                        <label class="control-label col-sm-6">Clave de Centro de Trabajo:</label>

                        <div class="col-sm-12">
                         @foreach($escuela as $e)
                         <input type="text"  class="form-control" name="clave_cct" id="clave_cct"value="{{$e['clave_cct']}}" readonly>
                         @endforeach
                       </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>


            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <div class="form-group two-fields">
                    <div class="input-group">
                     <div class="col-sm-6">
                      <label class="control-label col-sm-0" id="asterisco">*</label>

                      <label class="control-label col-sm-10">RVOE</label>
                      <input type="text"   class="form-control" id="rvoe" name="rvoe" placeholder="RVOE" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('rvoe')}}" required maxlength="15">
                      {!!$errors->first('rvoe','<small class="text-danger">:message</small><br>')!!}
                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-6">
                      <label class="control-label col-sm-0" id="asterisco">*</label>

                      <label class="control-label col-sm-10">Fecha de RVOE:</label>
                      <input type="Date" class="form-control" placeholder="Fecha de publicación" name="fecha_rvoe"  id="fecha_rvoe"  onchange="pasar();" value="{{old('fecha_rvoe')}}" required>

                      {!!$errors->first('fecha_rvoe','<small class="text-danger">:message</small><br>')!!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="form-group two-fields">
                  <div class="input-group">
                   <div class="col-sm-offset-2 col-sm-12">
                    <label class="control-label col-sm-0" id="asterisco">*</label>

                    <label class="control-label col-sm-10">Fecha de Publicación en el Periódico Oficial:</label>
                    <input type="Date" class="form-control"  placeholder="Fecha de publicación en el Periódico  Oficial" name="fecha_pub_periodico" id="fecha_pub_periodico"  value="{{old('fecha_pub_periodico')}}" required>
                    {!!$errors->first('fecha_pub_periodico','<small class="text-danger">:message</small><br>')!!}
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>


<!--
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="form-group two-fields">
                <div class="input-group">
                  <label class="control-label col-sm-0" id="asterisco">*</label>
                  <label class="control-label col-sm-11">Clave de Plan de Estudio:</label>

                  <div class="col-sm-offset-2 col-sm-12">

                    <input type="text" class="form-control"  placeholder="Clave de Plan de Estudio" name="clave_plan" id="clave_plan" value="{{old('clave_plan')}}" required >
                    {!!$errors->first('clave_plan','<small class="text-danger">:message</small><br>')!!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




       <div class="container">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="form-group two-fields">
                <div class="input-group">
                  <label class="control-label col-sm-0" id="asterisco">*</label>
                  <label class="control-label col-sm-11">Nombre de Plan de Estudio:</label>

                  <div class="col-sm-offset-2 col-sm-12">

                    <input type="text" class="form-control"  placeholder="Nombre de Plan de Estudio" name="nombre_plan" id="nombre_plan" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('nombre_plan')}}" required>
                    {!!$errors->first('nombre_plan','<small class="text-danger">:message</small><br>')!!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
-->


        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="form-group two-fields">
                <div class="input-group">
                 <label class="control-label col-sm-0" id="asterisco">*</label>
                 <label class="control-label col-sm-6">Tipo de Plan :</label>
                 <label class="control-label col-sm-0" id="asterisco">*</label>

                 <label class="control-label col-sm-5">Nivel Educativo:</label>
                 <div class="col-sm-6">
                  <select id="id_tipo_nivel" title="option" name="id_tipo_nivel" class="form-control" >@foreach($tipo as $t)<option id="opciones" class="form-control"  value="{{$t->id_tipo_nivel}}">{{$t->nombre_tipo_nivel}}</option>@endforeach
                    <option hidden selected>Tipo de Plan</option>
                    {!!$errors->first('tipo','<small>:message</small><br>')!!}

                  </select>

                </div>
                <span class="input-group-addon">        </span>
                <div class="col-sm-6">
                 <select id="id_nivel_educativo" title="option" name="id_nivel_educativo" class="form-control" >@foreach($nivel as $n)<option id="opciones" class="form-control"  value="{{$n->id_nivel_educativo}}">{{$n->nombre_nivel_educativo}}</option>@endforeach
                  <option hidden selected>Nivel Educativo</option>
                  {!!$errors->first('id_nivel_educativo','<small class="text-danger">:message</small><br>')!!}

                </select>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-12">
          <div class="form-group two-fields">
            <div class="input-group">
              <label class="control-label col-sm-0" id="asterisco">*</label>

              <label class="control-label col-sm-6">Modalidad:</label>
              <label class="control-label col-sm-0" id="asterisco">*</label>

              <label class="control-label col-sm-5">Oferta Educativa:</label>
              <div class="col-sm-6">
                <select id="id_modalidad" title="option" name="id_modalidad" class="form-control"  >@foreach($modal as $m)<option id="opciones" class="form-control"  value="{{$m->id_modalidad}}">{{$m->nombre_modalidad}}</option>@endforeach
                  <option hidden selected>Modalidad</option>
                  {!!$errors->first('id_modalidad','<small class="text-danger">:message</small><br>')!!}

                </select>

              </div>
              <span class="input-group-addon">        </span>
              <div class="col-sm-6">
               <select id="id_opcion_educativa" title="option" name="id_opcion_educativa" class="form-control" >@foreach($oferta as $o)<option id="opciones" class="form-control"  value="{{$o->id_opcion_educativa}}">{{$o->nombre_opcion_educativa}}</option>@endforeach
                <option hidden selected>Opción Educativa</option>
                {!!$errors->first('id_opcion_educativa','<small class="text-danger">:message</small><br>')!!}

              </select>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <div class="form-group two-fields">
          <div class="input-group">
            <label class="control-label col-sm-0" id="asterisco">*</label>

            <label class="control-label col-sm-6">Duración:</label>
            <label class="control-label col-sm-0" id="asterisco">*</label>

            <label class="control-label col-sm-5">Turno:</label>
            <div class="col-sm-6">
             <select id="id_duracion" title="option" name="id_duracion" class="form-control">@foreach($duracion as $d)<option id="opciones" class="form-control"  value="{{$d->id_duracion}}">{{$d->nombre_duracion}}</option>@endforeach
              <option hidden selected>Duración</option>
              {!!$errors->first('id_duracion','<small class="text-danger">:message</small><br>')!!}

            </select>

          </div>
          <span class="input-group-addon">        </span>
          <div class="col-sm-6">
           <select id="id_turno" title="option" name="id_turno" class="form-control" >@foreach($turno as $t)<option id="opciones" class="form-control"  value="{{$t->id_turno}}">{{$t->nombre_turno}}</option>@endforeach
            <option hidden selected>Turno</option>
            {!!$errors->first('id_turno','<small class="text-danger">:message</small><br>')!!}

          </select>

        </div>
      </div>
    </div>
  </div>
</div>
</div>



<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      <div class="form-group two-fields">
        <div class="input-group">
          <label class="control-label col-sm-0" id="asterisco">*</label>

          <label class="control-label col-sm-6">Año de Vigencia:</label>
          <label class="control-label col-sm-0" id="asterisco">*</label>

          <label class="control-label col-sm-5">Status de Plan:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Ej. FEB-JUN 2020" name="vigencia" id="vigencia" onkeyup="javascript:this.value=this.value.toUpperCase();" required maxlength="25">
            {!!$errors->first('vigencia','<small class="text-danger">:message</small><br>')!!}

          </div>
          <span class="input-group-addon">        </span>
          <div class="col-sm-6">
           <select id="id_status" title="option" name="id_status" class="form-control">@foreach($status as $s)<option id="opciones" class="form-control"  value="{{$s->id_status}}">{{$s->nombre_status}}</option>@endforeach
            <option hidden selected>Status de Plan</option>
            {!!$errors->first('id_status','<small class="text-danger">:message</small><br>')!!}

          </select>

        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="container">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="form-group two-fields">
                      <div class="input-group">
                        <label class="control-label col-sm-0" id="asterisco">*</label>
                        <label class="control-label col-sm-6">Calificación Mínima:</label>
                        <label class="control-label col-sm-0" id="asterisco">*</label>
                        <label class="control-label col-sm-5">Calificación Máxima:</label>
                        <div class="col-sm-6">

                         <input type="text"  class="form-control" name="calif_min" id="calif_min" value="{{old('calif_min')}}" placeholder="Calificación Mínima" required>

                       </div>
                       <span class="input-group-addon"></span>
                       <div class="col-sm-6">
                        <input type="text"  class="form-control" name="calif_maxima" id="calif_maxima" value="{{old('calif_maxima')}}" placeholder="Calificación Máxima" required>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <div class="container">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="form-group two-fields">
                <div class="input-group">
                  <label class="control-label col-sm-0" id="asterisco">*</label>
                  <label class="control-label col-sm-11">Calificación Mínima Aprobatoria:</label>

                  <div class="col-sm-offset-2 col-sm-12">

                    <input type="text" class="form-control"  placeholder="Calificación Mínima Aprobatoria" name="calif_aprobatoria" id="calif_aprobatoria" value="{{old('calif_aprobatoria')}}" required maxlength="10" >

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!--
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      <div class="form-group two-fields">
        <div class="input-group">
          <label class="control-label col-sm-6">Descripción del Plan de Estudios:</label>

          <div class="col-sm-offset-2 col-sm-12">

            <input type="text" class="form-control"  placeholder="Descripción Plan de Estudio" name="descripcion" id="descripcion"  >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

-->

<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      <div class="form-group two-fields">
        <div class="input-group">
         <div class="col-sm-offset-2 col-sm-12">
           <div>
            <button type="submit" class="btn btn-primary btn-block">Registrar Plan Estudio CPT</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


</form>

</form>
<div class="col-md-10 offset-md-15">
  <h5><a href="panel">Panel de Control</a></h5>
</div>


</div>
</div>

</div>
</div>

@endsection


<script>

  function valor(){
    date = new Date($('#fecha_rvoe').val())
    date.getDate()
  }

  $('#fecha_rvoe').on('change', function(){
    var date = new Date($('#fecha_rvoe').val());
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    alert([day, month, year].join('/'));
  });

  function ValidarFechas()
  {
    var fechainicial = document.getElementById("fecha_rvoe").value;
    var fechafinal = document.getElementById("fecha_pub_periodico").value;

    if(fechafinal.year > fechainicial.year || fechafinal.month > fechainicial.month || fechafinal.day > fechainicial.day)

      alert("La fecha final debe ser mayor a la fecha inicial");

  }

  $(document).ready(function(){
    $("#fecha_rvoe").datepicker({
     minDate: 0,
     maxDate: "+60D",
     numberOfMonths: 2,
     onSelect: function(selected) {
      $("#fecha_pub_periodico").datepicker("option","minDate", selected)
    }
  });

    $("#fecha_pub_periodico").datepicker({
     minDate: 0,
     maxDate:"+60D",
     numberOfMonths: 2,
     onSelect: function(selected) {
      $("#fecha_rvoe").datepicker("option","maxDate", selected)
    }
  });
  });

</script>

<script>

  function pasar() {
    var value = $("#fecha_rvoe").val();
    $("#fecha_pub_periodico").attr("min", value);
  }
</script>
