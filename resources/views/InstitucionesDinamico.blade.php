@extends('layouts.app')
<title>Registro de Instituciones</title>
@section('content')
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Instituciones</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<style>
  .container,
  .container-lg,
  .container-md,
  .container-sm,
  .container-xl {
    max-width: 2000px;
  }

  .table {
    width: 200%;
    margin-bottom: 1rem;
    color: #212529;
    background: white;
  }
</style>

<body class="bg-black">
  <div class="container">
    <br />
    <h1 align="center" class="text-white"> Registro de Instituciones </h1>
    <br />
    <div class="table-responsive">
      <form method="post" id="dynamic_form" class="bg-white">
        <span id="result"></span>
        <table class="table table-bordered table-striped" id="user_table" width="200%" background="white">
          <thead>
            <tr>
              <th width="5%">Clave CCT</th>
              <th width="5%">Clave de Institución DGPI</th>
              <th width="9%">Nombre</th>
              <th width="7%">Estado</th>
              <th width="7%">Municipio</th>
              <th width="4%">Código Postal</th>
              <th width="9%">Colonia</th>
              <th width="9%">Calle</th>
              <th width="3%">N° Int.</th>
              <th width="3%">N° Ext.</th>
              <th width="5%">Tel.</th>
              <th width="8%">Correo</th>
              <th width="8%">Página Web</th>

              <th width="3%">Acciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="14" align="right">&nbsp;</td>
              <td>
                @csrf
                <input type="submit" name="save" id="save" class="btn btn-primary" value="Guardar" />
              </td>
            </tr>

          </tfoot>
        </table>




    </div>
  </div>

  <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
  </div>

  </form>
  <a href="#" class="btn btn-primary  active" role="button" aria-pressed="true">Cargar Excel</a>

  <a href="PlanDinamico" class="btn btn-success  active" role="button" aria-pressed="true">Siguiente</a>
</body>

</html>

<script>
  $(document).ready(function() {

  var count = 1;

  dynamic_field(count);

   $(function() {
    $("#txtNumbers.form-control").keydown(function(event) {
      //alert(event.keyCode);
      if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
        return false;
      }
    });
  });

  function dynamic_field(number) {
    html = '<tr>';
    html += '<td><input type="text" name="clave_cct[]" maxlength="10"  class="form-control" /></td>';
    html += '<td><input type="text" name="clave_dgpi[]" maxlength="6"  class="form-control" /></td>';
    html += '<td><input type="text" name="nombre_institucion[]" onkeypress="return soloLetras(event)" class="form-control" /></td>';
    html += '<td><input type="text" name="estado[]" class="form-control"/> </td>';
    html += '<td><input type="text" name="municipio[]" class="form-control" /></td>';
    html += '<td><input type="text" name="codigo_postal[]" class="form-control" maxlength="5" id="txtNumbers" /></td>';
    html += '<td><input type="text" name="colonia[]" class="form-control" /></td>';
    html += '<td><input type="text" name="calle[]" class="form-control" /></td>';
    html += '<td><input type="number" name="numero_interior[]" class="form-control" /></td>';
    html += '<td><input type="number" name="numero_exterior[]" class="form-control" /></td>';
    html += '<td><input type="number" name="telefono[]" class="form-control" /></td>';
    html += '<td><input type="text" name="correo[]" class="form-control" /></td>';
    html += '<td><input type="text" name="pagina_web[]" class="form-control" /></td>';
if (number > 1) {
      html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Borrar</button></td></tr>';
      $('tbody').append(html);
    } else {
      html += '<td><button type="button" name="add" id="add" class="btn btn-success">Añadir</button></td></tr>';
      $('tbody').html(html);

    }
  }



  $(document).on('click', '#add', function() {

    count++;
    dynamic_field(count);

    $(function() {
      $("#txtNumbers.form-control").keydown(function(event) {
        //alert(event.keyCode);
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
          return false;
        }
      });
    });

  });

  $(document).on('click', '.remove', function() {
    count--;
    $(this).closest("tr").remove();
  });


  $('#dynamic_form').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: '{{ route("array") }}',
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function() {
          $('#save').attr('disabled', 'disabled');
        },
        success: function(data) {
          if(data.error)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<p>'+data.error[count]+'</p>';
                    }
                    $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                }
                else
                {
                    dynamic_field(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                    console.log(data);
                }
                $('#save').attr('disabled', false);
        }
         })
 });
});


</script>

@endsection

<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }

    $(function() {
      $("#txtNumbers").keydown(function(event) {
        //alert(event.keyCode);
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
          return false;
        }
      });
    });

</script>
