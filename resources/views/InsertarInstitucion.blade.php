<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">

@extends('layouts.app')
<title>Registro Instituciones</title>
@section('content')
<style>
  #municipio select:focus,
  #municipio input:focus {
    outline: none;
  }
</style>



<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card card-default">
      <div class="card-heading">
        <center>
          <h2>INGRESE LOS DATOS DE LA INSTITUCÓN</h2>
          <center>
      </div>

      <div class="card-body">
        <form action="{{ route('store',registroInstitucion')}}" method="post">
          {{csrf_field()}}


          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <input type="text" class="form-control" maxlength="120" placeholder="Nombre de la Institución" name="nombre_institucion">
                        {!! $errors->first('nombre_institucion','<small>:message</small><br>') !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>




          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-6">
                      <input type="text" class="form-control" maxlength="12" placeholder="Clave de Centro de Trabajo" name="clave_cct" required="unique">
                    </div>
                    <span class="input-group-addon"></span>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" maxlength="10" placeholder="Clave de Institución DGP" name="clave_dgpi" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-4">
                      <input type="text" maxlength="5" class="form-control" onChange="getDirecciones()" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required>
                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" maxlength="10" placeholder="Calle" name="calle" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-6">
                      <input type="text" class="form-control" maxlength="5" placeholder="Número Interior" name="numero_interior">
                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" maxlength="5" placeholder="Número Exterior" name="numero_exterior" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <select id="colonia" name="colonia" class="form-control" required>
                          <option hidden selected>Colonia</option>
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
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-offset-2 col-sm-12">
                      <div>
                        <select id="municipio" name="municipio" onchange="this.nextElementSibling.value=this.value" class="form-control" required>
                          <option hidden selected>Municipio</option>
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
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <label class="control-label col-sm-12">Datos de Directivo Autorizado:</label>

                    <div class="col-sm-5">
                      <select id="id_tipo_directivo" title="option" name="id_tipo_directivo" class="form-control">@foreach($tipos as $t)<option id="opciones" class="form-control" value="{{$t['id_tipo_directivo']}}">{{$t['nombre_tipo_directivo']}}</option>@endforeach
                        <option hidden selected>Selecciona una opción</option>
                      </select>
                    </div>
                    <span class="input-group-addon"> </span>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" maxlength="40" placeholder="Nombre de Directivo" name="directivo_autorizado" required pattern="[A-Za-z ñ .]+"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-10">
                <div class="form-group two-fields">
                  <div class="input-group">
                    <div class="col-sm-offset-2 col-sm-12">
                      <label class="control-label col-sm-8">Reglamento Institucional:</label>
                      <div>
                        <input type="file" class="form-control" maxlength="10" placeholder="Adjunte el reglamento" name="reglamento_institucional" required pattern="[A-Za-z ñ]+">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-10">
                  <div class="form-group two-fields">
                    <div class="input-group">
                      <div class="col-sm-offset-2 col-sm-12">

                        <label class="control-label col-sm-12">Manual de Organización:</label>
                        <input type="file" class="form-control" maxlength="10" placeholder="Adjunte el reglamento" name="manual_organizacion" required>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-10">
                  <div class="form-group two-fields">
                    <div class="input-group">
                      <div class="col-sm-offset-2 col-sm-12">

                        <input type="text" class="form-control" maxlength="40" placeholder="Pagina Web" name="pagina_web" required>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-10">
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
      </div>
    </div>
  </div>
</div>

@endsection

<script>
  function getDirecciones() {

    var endpoint_sepomex = "http://api-sepomex.hckdrk.mx/query/";
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
        var sel = document.getElementById("municipio");
        sel.remove(sel.selectedIndex);
        var select1 = document.getElementById("municipio");
        var option1 = document.createElement("option");

        option1.innerHTML = respuesta[1]["response"]["municipio"];
        select1.appendChild(option1);
        //
        var sel2 = document.getElementById("estado");
        sel2.remove(sel2.selectedIndex);
        var select2 = document.getElementById("estado");
        var option2 = document.createElement("option");

        option2.innerHTML = respuesta[1]["response"]["estado"];
        select2.appendChild(option2);
        console.log(respuesta);
      },
      error: function() {
        console.log("No se ha podido obtener la información");
      }
    });
  }
</script>
<script>
  $('#colonia').editableSelect();
</script>
