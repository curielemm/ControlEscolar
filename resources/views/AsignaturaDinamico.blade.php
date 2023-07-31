@extends('layouts.app')
<title>Registro de Asignaturas</title>
@section('content')
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Asignaturas </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body  class="bg-black">
  <div class="container">
     <br />
     <h1 align="center" class="text-white"> Registro de Asignaturas </h1>
     <br />
   <div class="table-responsive">
                <form method="post" id="dynamic_form" class="bg-white">
                 <span id="result"></span>
                 <table class="table table-bordered table-striped" id="user_table" background="white"
                  >
               <thead >
                <tr>
                    
                    <th  width="12%">Clave</th>
                    <th  width="16%">Asignatura</th>
                    <th  width="8%">N° Creditos</th>
                    <th  width="12%">Seriazion</th>
                    <th  width="10%">Tipo de Asignatura</th>
                    <th  width="12%">Plan Estudios</th>
                    <th  width="12%">Escolaridad</th>
                    <th  width="8%">Acciones</th>
                </tr>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                <tr>
                                <td colspan="7" align="right">&nbsp;</td>
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
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

             <a href="#" class="btn btn-primary  active" role="button" aria-pressed="true">Cargar Excel</a>

            <a href="DocenteDinamico" class="btn btn-success  active" role="button" aria-pressed="true">Siguiente</a>

 </body>
</html>

<script>
$(document).ready(function(){

 var count = 1;

 dynamic_field3(count);

 function dynamic_field3(number)
 {
  html = '<tr>';

        html += '<td><input type="text" name="clave_asignatura[]" class="form-control" /></td>';
        html += '<td><input type="text" name="nombre_asignatura[]" class="form-control" /></td>';
        html += '<td><input type="number" min="1" max="13" name="no_creditos[]" class="form-control" /></td>';
        html += '<td><input type="text" name="seriazion[]" class="form-control" /></td>';
        html += '<td><input type="int" name="tipo_asignatura[]" class="form-control"/> </td>';


        html += '<td><select name="clave_plan[]" class="form-control" placeholder="plan" id="selector">@foreach($plan as $nombre)<option id="opciones" class="form-control"  value={{$nombre['clave_plan']}}>{{$nombre['nombre_plan']}}</option>@endforeach<option hidden selected>Selecciona una opción</option></select>  </td>';


        html += '<td><input type="boolean" name="semestre_cuatrimestre[]" class="form-control" /></td>';
      

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
  dynamic_field3(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:'{{ route("dynamic-field3.insert") }}',
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
                    dynamic_field3(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                }
                $('#save').attr('disabled', false);
            }
        })
 });

});
</script>
@endsection
