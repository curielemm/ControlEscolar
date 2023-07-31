
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@extends('layouts.app')
<title>Registro Plan</title>
@section('content')


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
            <h2>REGISTRO DE PLANES DE ESTUDIOS</h2>
                        <h2>"CAPACITACIÓN PARA EL TRABAJO"</h2>

            <center>
            </div>

            <div class="card-body" >
              <form  action="{{ route('registroPlanesCPTVarios')}}" method="post" id="planes" >
                @csrf
                <center><label class="control-label col-sm-11" id="obligatorios" >* Datos  obligatorios</label></center>

                <div class="container">
                  <div class="row">
                    <div class="col-xs-12 col-md-12">
                      <div class="form-group two-fields">
                        <div class="input-group">
                         <div class="col-sm-offset-2 col-sm-12">
                                                  <label class="control-label col-sm-0" id="asterisco">*</label>

                         <label class="control-label col-sm-11">Selecciona una Institución:</label>

                           <div>
                            <select id="nombre_institucion" title="option" name="nombre_institucion" class="form-control" >
                              @foreach($escuela as $e)

                              <option id="opciones" class="form-control"  value="{{$e->clave_cct}}">{{$e->nombre_institucion}}</option>
                              @endforeach

                            <option hidden selected></option>

                        </select>
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

                         <input type="text"  class="form-control" name="clave_cct" id="clave_cct"value="{{old('clave_cct')}}" readonly>

                       </div>
                       <span class="input-group-addon"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>


  <!--    <div class="container">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="form-group two-fields">
                <div class="input-group">
                  <label class="control-label col-sm-0" id="asterisco">*</label>
                  <label class="control-label col-sm-11">Nombre de Licenciatura, Especialidad o Doctorado:</label>

                  <div class="col-sm-offset-2 col-sm-12">

                    <input type="text" class="form-control"  placeholder="Nombre de Licenciatura, Especialidad o Doctorado" name="nombre_plan" id="nombre_plan" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('nombre_plan')}}" required>
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
                      <label class="control-label col-sm-0" id="asterisco">*</label>
                    <label class="control-label col-sm-10">Fecha de Publicación en el Periódico Oficial:</label>
                   <div class="col-sm-offset-2 col-sm-12">

                    <input type="Date" class="form-control"  placeholder="Fecha de publicación en el periódico escolar" name="fecha_pub_periodico" id="fecha_pub_periodico"  value="{{old('fecha_pub_periodico')}}" required>
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

                    <input type="text" class="form-control"  placeholder="Clave de Plan de Estudio" name="clave_plan" id="clave_plan" value="{{old('clave_plan')}}" required maxlength="10">
                    {!!$errors->first('clave_plan','<small class="text-danger">:message</small><br>')!!}
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
                 <label class="control-label col-sm-6">Tipo de Plan de Estudio:</label>
                 <label class="control-label col-sm-0" id="asterisco">*</label>

                 <label class="control-label col-sm-5">Nivel Educativo:</label>
                 <div class="col-sm-6">
                  <select id="id_tipo_nivel" title="option" name="id_tipo_nivel" class="form-control" >@foreach($tipo as $t)<option id="opciones" class="form-control"  value="{{$t->id_tipo_nivel}}">{{$t->nombre_tipo_nivel}}</option>@endforeach
                    <option hidden selected>Tipo de Plan</option>
                    {!!$errors->first('id_tipo_nivel','<small>:message</small><br>')!!}

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

            <label class="control-label col-sm-6">Duración de ciclo:</label>
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

<!--
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      <div class="form-group two-fields">
        <div class="input-group">
          <label class="control-label col-sm-6">Descripción del Plan de Estudios:</label>

          <div class="col-sm-offset-2 col-sm-12">

            <input type="text" class="form-control"  placeholder="Descripción Plan de Estudio" name="descripcion" id="descripcion"  onkeyup="countChars(this);" maxlength="50">
            <p id="charNum" align="right"><font size="2">45 caracteres restantes</font></p>

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

  function pasar() {
    var value = $("#fecha_rvoe").val();
    $("#fecha_pub_periodico").attr("min", value);
  }
</script>

<script>
    $(document).ready(function () {
      $('#nombre_institucion').selectize({
          sortField: 'text'
      });
  });


  $(function(){

    $(document).on('change','#nombre_institucion',function(){
     //detectamos el evento change
      var value = $(this).val();//sacamos el valor del select
      $('#clave_cct').val(value);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
    });
  });

</script>

<script>
 function countChars(obj){
    var maxLength = 45;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);

    if(charRemain < 0){
        document.getElementById("charNum").innerHTML = '<span style="color: red;" size="1.5">Limite de caracteres exedido '+maxLength+' caracteres </span>';
    }else{
        document.getElementById("charNum").innerHTML = '<font size="2">' + charRemain + '</font>' + '<font size="2">caracteres restantes</font>';
    }
}
</script>
