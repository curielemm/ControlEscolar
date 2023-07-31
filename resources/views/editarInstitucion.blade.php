<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">

@extends('layouts.app')
<title>Editar Institucion</title>


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
                    <h4>MODIFIQUE LOS DATOS DE LA INSTITUCIÓN</h4>
                    <center>
            </div>



            <div class="card-body">
                <form action="{{ route('updateInstitucion',$uno->clave_cct)}}" method="post">
                    @csrf
                    <center><label class="control-label col-sm-11" id="obligatorios">* Datos obligatorios</label></center>


                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group two-fields">
                                    <div class="input-group">
                                        <label class="control-label col-sm-0" id="asterisco">*</label>
                                        <label class="control-label col-sm-11">Nombre de la Institución:</label>
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <div>
                                                <input type="text" class="form-control" placeholder="Nombre de la Institución" name="nombre_institucion" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->nombre_institucion}}" required>
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
                                        <label class="control-label col-sm-11">Nivel de Institución:</label>

                                        <div class="col-sm-12">
                                            <select id="id_tipo_institucion" title="option" name="id_tipo_institucion" class="form-control">@foreach($tipoIns as $t)<option id="opciones" class="form-control" value="{{$t->id_tipo_institucion}}" required readonly>{{$t->nombre_tipo_institucion}}</option>@endforeach
                                            </select>
                                            {!! $errors->first('id_tipo_institucion','<small class="text-danger">:message</small><br>') !!}
                                       
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
                                        <label class="control-label col-sm-5">Clave de Institución DGP:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Clave de Centro de Trabajo" name="clave_cct" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->clave_cct}}" required>
                                            {!!$errors->first('clave_cct','<small class="text-danger">:message</small><br>')!!}



                                        </div>

                                        <span class="input-group-addon"></span>

                                        <div class="col-sm-6">

                                            <input type="text" class="form-control" placeholder="Clave de Institución DGP" name="clave_dgpi" value="{{$uno->clave_dgpi}}" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                                            {!!$errors->first('clave_dgpi','<small class="text-danger">:message</small><br>')!!}
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

                                            <input type="text" class="form-control" value="{{$uno->codigo_postal}}" onChange="getDirecciones()" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required>
                                            {!! $errors->first('codigo_postal','<small class="text-danger">:message</small><br>') !!}

                                        </div>
                                        <span class="input-group-addon"> </span>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Calle" name="calle" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->calle}}" required>
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
                                            <input type="text" class="form-control" placeholder="Número Exterior" name="numero_exterior" id="numero_exterior" value="{{$uno->numero_exterior}}" required>
                                            {!! $errors->first('numero_exterior','<small class="text-danger">:message</small><br>') !!}


                                        </div>
                                        <span class="input-group-addon"> </span>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Número Interior" name="numero_interior" id="numero_interior" value="{{$uno->numero_interior}}">
                                            {!! $errors->first('numero_interior','<small class="text-danger">:message</small><br>') !!}
                                       
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
                                                <select id="colonia" name="colonia" onchange="this.nextElementSibling.value=this.value" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->colonia}}" required>
                                                    <option value="{{$uno->colonia}}" hidden selected>{{$uno->colonia}}</option>
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
                                                <select id="municipio" name="municipio" onchange="this.nextElementSibling.value=this.value" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$uno->municipio}}" required>
                                                    <option hidden value="{{$uno->colonia}}" selected>{{$uno->municipio}}</option>
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
                                            <select id="id_tipo_directivo" title="option" name="id_tipo_directivo" class="form-control">
                                                <option value="{{$uno->id_tipo_directivo}}" hidden selected>{{$uno->nombre_tipo_directivo}}</option>
                                                @foreach($tipos as $t)<option id="opciones" class="form-control" value="{{$t['id_tipo_directivo']}}">{{$t['nombre_tipo_directivo']}}</option>@endforeach
                                            </select>
                                            {!! $errors->first('id_tipo_directivo','<small class="text-danger">:message</small><br>') !!}
                                       
                                        </div>
                                        <span class="input-group-addon"> </span>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Nombre de Directivo" value="{{$uno->directivo_autorizado}}" name="directivo_autorizado" id="directivo_autorizado" required>
                                            {!! $errors->first('directivo_autorizado','<small class="text-danger">:message</small><br>') !!}
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


                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group two-fields ">
                                    <div class="input-group">
                                        <label class="control-label col-sm-0" id="asterisco">*</label>
                                        <label class="control-label col-sm-11">Página Web:</label>

                                        <div class="col-sm-offset-2 col-sm-12">

                                            <input type="text" class="form-control" placeholder="Pagina Web" name="pagina_web" value="{{$uno->pagina_web}}" >
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
                                                <button type="submit" class="btn btn-warning btn-block">Editar Institución</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
                <div class="col-md-10 offset-md-15">
                    <h5><a href="{{route('panel')}}">Panel de Control</a></h5>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>



<script>
    function getDirecciones() {

        var endpoint_sepomex = "https://api-sepomex.hckdrk.mx/query/";
    var method_sepomex = 'info_cp/';
    var cp = document.getElementById("codigo_postal").value;
    var variable_string = '?type=simplified';
    var url2 = endpoint_sepomex + method_sepomex + cp + "?token=641a60b8-e7f1-4f9a-81d5-ab82b907906a";
    var selecte = $('#colonia');
    var selecc = $('#municipio');
    selecte.find('option').remove();
    selecc.find('option').remove();
    selecte.editableSelect('destroy');
    selecc.editableSelect('destroy');

    $.ajax({
      url: url2,
      success: function(respuesta) {
        $(respuesta).each(function(i, v) { // indice, valor
          selecte.append('<option value="' + v.response.asentamiento + '">' + v.response.asentamiento + '</option>');
        })
        selecc.append('<option value="' + respuesta[0].response.municipio + '">' + respuesta[0].response.municipio + '</option>');
       selecte.editableSelect();
       selecc.editableSelect();
      },

      error: function() {
        $('#colonia').editableSelect();
        $('#municipio').editableSelect();
        console.log("No se ha podido obtener la información");
      }
    });

    }
</script>
<script>
  function countChars(obj) {
    var maxLength = 45;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);

    if (charRemain < 0) {
      document.getElementById("charNum").innerHTML = '<span style="color: red;" size="1.5">Limite de caracteres exedido ' + maxLength + ' caracteres </span>';
    } else {
      document.getElementById("charNum").innerHTML = '<font size="2">' + charRemain + '</font>' + '<font size="2">caracteres restantes</font>';
    }
  }
</script>
<script src="https://rawgit.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="https://rawgit.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet" />

@endsection