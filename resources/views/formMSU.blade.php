<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">

@extends('layouts.app')
<title>Registro Instituciones</title>


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

}
</style>


<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card card-default">
      <div class="card-heading">
        <center>
          <h4>INGRESE DATOS DE LA INSTITUCIÓN</h4>
                    <h4>"MEDIA SUPERIOR"</h4>

          <center>
      </div>



      <div class="card-body">
        <form action="{{ route('registroInstitucionMSU')}}" method="post">
          @csrf
         <center><label class="control-label col-sm-11" id="obligatorios" >* Datos  obligatorios</label></center>


          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <label class="control-label col-sm-0" id="asterisco">*</label>
                    <label class="control-label col-sm-11">Nombre de la Institución:</label>
                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <input type="text" class="form-control" placeholder="Nombre de la Institución" name="nombre_institucion" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('nombre_institucion')}}" required maxlength="150">
                        {!! $errors->first('nombre_institucion','<small class="text-danger">:message</small><br>') !!}
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
                    <label class="control-label col-sm-0" id="asterisco">*</label>
                    <label class="control-label col-sm-5">Nivel de Institución:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Clave de Centro de Trabajo" name="clave_cct" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('clave_cct')}}" required maxlength="16">
                      {!!$errors->first('clave_cct','<small class="text-danger">:message</small><br>')!!}



                    </div>

                    <span class="input-group-addon"></span>

                    <div class="col-sm-6">

                       <select id="id_tipo_institucion" title="option" name="id_tipo_institucion" class="form-control">@foreach($tipoIns as $t)<option id="opciones" class="form-control" value="{{$t->id_tipo_institucion}}" required readonly>{{$t->nombre_tipo_institucion}}</option>@endforeach
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
                    <label class="control-label col-sm-4">Código Postal:</label>
                    <label class="control-label col-sm-0" id="asterisco">*</label>
                    <label class="control-label col-sm-6">Calle:</label>
                    <div class="col-sm-4">

                      <input type="text" class="form-control" onChange="getDirecciones()" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required maxlength="6">
                      {!! $errors->first('codigo_postal','<small class="text-danger">:message</small><br>') !!}

                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Calle" name="calle" onkeyup="javascript:this.value=this.value.toUpperCase();countChars(this);" value="{{old('calle')}}" required max="51">
                      <p id="charNum" align="right"><font size="1.7">50 caracteres restantes</font></p>
                      {!! $errors->first('calle','<small class="text-danger">:message</small><br>') !!}

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
                    <label class="control-label col-sm-6">Número Exterior:</label>
                    <label class="control-label col-sm-5">Número Interior:</label>

                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Número Exterior" name="numero_exterior" id="numero_exterior" value="{{old('numero_exterior')}}" required maxlength="25" onkeyup="javascript:this.value=this.value.toUpperCase();" >
                      {!! $errors->first('numero_exterior','<small class="text-danger">:message</small><br>') !!}


                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Número Interior" name="numero_interior" id="numero_interior" value="{{old('numero_interior')}}" maxlength="25" onkeyup="javascript:this.value=this.value.toUpperCase();" >
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
                    <label class="control-label col-sm-11">Colonia:</label>

                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <select id="colonia" name="colonia" onchange="this.nextElementSibling.value=this.value" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('colonia')}}" required>
                          <option hidden selected>Colonia</option>
                        </select>
                        {!! $errors->first('colonia','<small class="text-danger">:message</small><br>') !!}

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
                    <label class="control-label col-sm-11">Municipio:</label>

                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <select id="municipio" name="municipio" onchange="this.nextElementSibling.value=this.value" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('municipio')}}" required>
                          <option hidden selected>Municipio</option>
                        </select>
                        {!! $errors->first('municipio','<small class="text-danger">:message</small><br>') !!}

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
                    <label class="control-label col-sm-11">Datos de Directivo Autorizado:</label>

                    <div class="col-sm-5">
                      <select id="id_tipo_directivo" title="option" name="id_tipo_directivo" class="form-control">@foreach($tipos as $t)<option id="opciones" class="form-control" value="{{$t['id_tipo_directivo']}}">{{$t['nombre_tipo_directivo']}}</option>@endforeach
                        <option hidden selected>Selecciona una opción</option>
                      </select>
                       {!! $errors->first('id_tipo_directivo','<small class="text-danger">:message</small><br>') !!}
                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Nombre de Directivo" name="directivo_autorizado" id="directivo_autorizado" required maxlength="50">
                       {!! $errors->first('directivo_autorizado','<small class="text-danger">:message</small><br>') !!}
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
                    <label class="control-label col-sm-11">Periódico Oficial:</label>

                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <input type="file" class="form-control" name="periodico_oficial" value="{{old('periodico_oficial')}}" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png">
                         {!! $errors->first('periodico_oficial','<small class="text-danger">:message</small><br>') !!}
                      </div>
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
                    <label class="control-label col-sm-11">Manual de Organización:</label>

                    <div class="col-sm-offset-2 col-sm-12">

                      <input type="file" class="form-control" placeholder="Adjunte el reglamento" name="manual_organizacion" accept="application/pdf">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

-->


<!--  <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <label class="control-label col-sm-0" id="asterisco">*</label>
                    <label class="control-label col-sm-11">Tipo de Institucion:</label>

                    <div class="col-sm-12">
                      <select id="id_tipo_institucion" title="option" name="id_tipo_institucion" class="form-control">@foreach($tipos as $t)<option id="opciones" class="form-control" value="{{$t->id_tipo_institucion}}">{{$t->nombre_tipo_institucion}}</option>@endforeach
                        <option hidden selected>Selecciona una opción</option>
                      </select>
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
                <div class="form-group two-fields ">
                  <div class="input-group">
                    <label class="control-label col-sm-11">Página Web:</label>

                    <div class="col-sm-offset-2 col-sm-12">

                      <input type="text" class="form-control" placeholder="Pagina Web" name="pagina_web" value="{{old('pagina_web')}}" maxlength="45">
                      {!! $errors->first('pagina_web','<small class="text-danger">:message</small><br>') !!}

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
                        <button type="submit" class="btn btn-primary btn-block">Registrar Institución</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </form>
        <div class="col-md-10 offset-md-15">
          <h5><a href="panel">Panel de Control</a></h5>
        </div>


      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>

@endsection


<script>
  function getDirecciones() {

    var endpoint_sepomex = "https://api-sepomex.hckdrk.mx/query/";
    var method_sepomex = 'info_cp/';
    var cp = document.getElementById("codigo_postal").value;
    var variable_string = '?type=simplified';
    var url2 = endpoint_sepomex + method_sepomex + cp;
    var selecte = document.getElementById("colonia");
    console.log(selecte.length);
    var j = 0;
    while (j < selecte.length) {
      selecte.remove(j);
    }
    console.log(selecte.length);

    $.ajax({
      url: url2,
      success: function(respuesta) {


        for (var i = 0; i < respuesta.length; i++) {


          var content = respuesta; //[i]["response"]["colonia"];
          var select = document.getElementById("colonia");
          var option = document.createElement("option");
          option.innerHTML = content[i]["response"]["asentamiento"];
          select.appendChild(option);

          // var content = respuesta; //[i]["response"]["colonia"];


        }
        $('#colonia').editableSelect();
        var sel = document.getElementById("municipio");
        sel.remove(sel.selectedIndex);
        var select1 = document.getElementById("municipio");
        var option1 = document.createElement("option");

        option1.innerHTML = respuesta[1]["response"]["municipio"];
        select1.appendChild(option1);
        //
                $('#municipio').editableSelect();

      },

      error: function() {
        console.log("No se ha podido obtener la información");
      }


    });


  }
</script>


<script>
 function countChars(obj){
    var maxLength = 50;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);

    if(charRemain < 0){
        document.getElementById("charNum").innerHTML = '<span style="color: red;" size="1.5">Limite de caracteres exedido '+maxLength+' caracteres </span>';
    }else{
document.getElementById("charNum").innerHTML = '<font size="2">' + charRemain + '</font>' + '<font size="2">caracteres restantes</font>';    }
}
</script>
