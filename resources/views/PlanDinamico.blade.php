@extends('layouts.app')
<title>Registro de Planes</title>
@section('content')

<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Plan de Estudio </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <style>

.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 2000px;
}
.table {
    width: 200%;
    margin-bottom: 1rem;
    color: #212529;
    background: white;
}

 </style>


  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body  class="bg-black">
  <div class="container">
     <br />
     <h1 align="center" class="text-white"> Registro de Plan de Estudios </h1>
     <br />
     <div>

     </div>
   <div class="table-responsive">

                <div>
                  <select id="clave_cct" title="option" name="clave_cct[]" class="form-control" >@foreach($escuela as $dos)<option id="opciones" class="form-control"  value={{$dos['clave_cct']}}>{{$dos['nombre_institucion']}}</option>@endforeach
                        <option hidden selected>Selecciona Institucion</option>
                  </select>

                </div>

                <form method="post" id="dynamic_form" class="bg-white">
                 <span id="result"></span>


                 <table class="table table-bordered table-striped" id="user_table" background="white"
                  >
               <thead >
                <tr>
                    <th  width="8%">Institución</th>

                    <th  width="8%">Clave de Plan</th>
                    <th  width="8%">Clave de Plan DGP</th>
                    <th  width="10%">REVOE</th>
                    <th  width="12%">Nombre de Plan</th>
                    <th  width="8%">Vigencia</th>
                    <th  width="8%">N° Creditos</th>
                    <th  width="8%">Duración</th>
                    <th  width="12%">Descripción</th>
                    <th  width="8%">Estado</th>
                    <th  width="8%">Modalidad</th>
                    <th  width="8%">Acciones</th>
                </tr>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                <tr>
                                <td colspan="11" align="right">&nbsp;</td>
                                <td>
                  @csrf
                  <input type="submit" name="save" id="save" class="btn btn-primary" value="Guardar" />
                 </td>
                </tr>

               </tfoot>
           </table>

                </form>



   </div>
  </div>

            <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <a href="#" class="btn btn-primary  active" role="button" aria-pressed="true">Cargar Excel</a>

            <a href="AsignaturaDinamico" class="btn btn-success  active" role="button" aria-pressed="true">Siguiente</a>

 </body>
</html>

<script>
$(document).ready(function(){

 var count = 1;

 dynamic_field5(count);

  //document.getElementById('opciones').index = 0;

$(function(){
    $(document).on('change','#clave_cct.form-control',function(){ //detectamos el evento change
      var value = $(this).val();//sacamos el valor del select
      $('#institucion.form-control').val(value);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
    });
  });


 function dynamic_field5(number)
 {

  html = '<tr>';


        html += '<td><input type="text" id="institucion" name="clave_cct[]" readonly class="form-control" /></td>';


        html += '<td><input type="text" name="clave_plan[]" maxlength="6"  class="form-control" /></td>';
        html += '<td><input type="text" name="clave_dgp[]" class="form-control" /></td>';
        html += '<td><input type="text" name="revoe[]" maxlength="15"  class="form-control" /></td>';
        html += '<td><input type="text" name="nombre_plan[]" class="form-control" /></td>';
        html += '<td><input type="date" name="vigencia[]" class="form-control" /></td>';
        html += '<td><input type="number" name="no_creditos[]" class="form-control" min="1" max="300"/> </td>';
        html += '<td><input type="text" name="duracion_ciclo[]" class="form-control" /></td>';
        html += '<td><input type="text" name="descripcion[]" class="form-control" /></td>';

        html += '<td><select name="id_status[]" class="form-control">@foreach($status as $st)<option id="opciones" class="form-control"  value={{$st['id_status']}}> {{$st['nombre_status']}} </option>@endforeach<option hidden selected>Selecciona una opción</option></select></td>';

         html += '<td><select name="id_modalidad[]" class="form-control">@foreach($modal as $md)<option id="opciones" class="form-control"  value={{$md['id_modalidad']}}> {{$md['nombre_modalidad']}} </option>@endforeach<option hidden selected>Selecciona una opción</option></select></td>';

        if(number > 1)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Borrar</button></td></tr>';
            $('tbody').append(html);
        }
        else
        {
            html += '<td><button type="button" name="add" id="add" class="btn btn-success">Añadir</button></td></tr>';
            $('tbody').html(html);
        }


 }

 $(document).on('click', '#add', function(){
  count++;
  dynamic_field5(count);

  $(function(){
    $(document).on('change','#clave_cct.form-control',function(){ //detectamos el evento change
      var value = $(this).val();//sacamos el valor del select
      $('#institucion.form-control').val(value);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
    });
  });

 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:'{{ route("dynamic-field5.insert") }}',
            method:'post',
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function(){
                $('#save').attr('disabled','disabled');
            },
            success:function(data)
            {
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
                    dynamic_field5(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                    console.log(data);
                }
                $('#save').attr('disabled', false);
            }
        })
 });
});
</script>



<script>

  $(function(){
    $(document).on('change','#escuelas',function(){ //detectamos el evento change
      var value = $(this).val();//sacamos el valor del select
      $('#prueba').val(value);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
    });
  });

</script>
@endsection
