@extends('layouts.app')
<title>Registro de Grupos</title>
@section('content')
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Grupos </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body  class="bg-black">
  <div class="container">
     <br />
     <h1 align="center" class="text-white"> Registro de Grupos </h1>
     <br />
   <div class="table-responsive">
                <form method="post" id="dynamic_form" class="bg-white">
                 <span id="result"></span>
                 <table class="table table-bordered table-striped" id="user_table" background="white"
                  >
               <thead >
                <tr>
                    <th  width="10%">Clave</th>
                    <th  width="12%">Nombre de Grupo</th>
                    <th  width="5%">Semestre</th>
                    <th  width="12%">Periodo Escolar</th>
                    <th  width="12%">Docente</th>
                    <th  width="12%">Asignatura</th>
                    <th  width="5%">Turno</th>
                    <th  width="6%">Acciones</th>
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
                <a href="AlumnosDinamico">
                  <input type="submit"  id="siguiente" value="Siguiente" color="red" class="btn btn-primary"/>
                </a>

   </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 var count = 1;

 dynamic_field4(count);

 function dynamic_field4(number)
 {
  html = '<tr>';
        html += '<td><input type="text" name="clave_grupo[]" class="form-control" /></td>';
        html += '<td><input type="text" name="nombre_grupo[]" class="form-control" /></td>';
        html += '<td><input type="number" name="no_semestre[]" class="form-control" /></td>';
        html += '<td><input type="text" name="periodo_escolar[]" class="form-control" /></td>';
        
        html += '<td><select name="clave_docente[]" class="form-control" placeholder="Docente" id="selector">@foreach($docente as $dos)<option id="opciones" class="form-control"  value={{$dos['rfc']}}>{{$dos['nombre']." ".$dos['apellido_paterno']}}</option>@endforeach</select>  </td>';

        html += '<td><select name="clave_asignatura[]" class="form-control" placeholder="Asignatura" id="selector">@foreach($asignatura as $nombre)<option id="opciones" class="form-control"  value={{$nombre['clave_asignatura']}}>{{$nombre['nombre_asignatura']}}</option>@endforeach</select>  </td>';

        html += '<td><input type="text" name="turno[]" class="form-control" /></td>';
      
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
  dynamic_field4(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:'{{ route("dynamic-field4.insert") }}',
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
                    dynamic_field4(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                }
                $('#save').attr('disabled', false);
            }
        })
 });

});
</script>


@endsection
