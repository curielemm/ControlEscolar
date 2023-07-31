@extends('layouts.app')
<title>Registro de Planes</title>
@section('content')
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Plan de Estudio </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body  class="bg-black">
  <div class="container">
     <br />
     <h1 align="center" class="text-white"> Registro de Plan de Estudios </h1>
     <br />
   <div class="table-responsive">
                <form method="post" id="dynamic_form" class="bg-white">
                 <span id="result"></span>
                 <table class="table table-bordered table-striped" id="user_table" background="white"
                  >
               <thead >
                <tr>
    
                    <th  width="40%">Institucion</th>
                    <th  width="40%">Plan de estudios</th>
                    <th  width="8%">Acciones</th>
                </tr>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                <tr>
                                <td colspan="2" align="right">&nbsp;</td>
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

 dynamic_field6(count);



 function dynamic_field6(number)
 {
  html = '<tr>';
        
        html += '<td><select name="clave_cct[]" class="form-control" title="Escuela" id="selectorI2"></select></td>';

        html += '<td><select name="clave_cct[]" class="form-control" title="Escuela" id="selectorI" onclick="volcarSelects("selectorI", "selectorI2")">@foreach($escuela as $dos)<option id="opciones"  class="form-control"  value={{$dos['clave_cct']}}>{{$dos['nombre_institucion']}}</option>@endforeach</select></td>';

        html += '<td><select name="clave_plan[]" class="form-control" placeholder="Docente" id="selector">@foreach($plan as $dos)<option id="opciones" class="form-control"  value={{$dos['clave_plan']}}>{{$dos['nombre_plan']}}</option>@endforeach</select></td>';
       

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
  dynamic_field6(count);
          
  // Get the button, and when the user clicks on it, execute myFunction
  //prueba selector
 // document.getElementById('selectorI').selectedIndex =2;
  //var sel = document.getElementById('selectorI'); 
  //var opt = sel.options[sel.selectedIndex]; 

 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:'{{ route("dynamic-field6.insert") }}',
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
                    dynamic_field6(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                }
                $('#save').attr('disabled', false);
            }
        })
 }

 );

});
</script>



<<<<<<< HEAD
@endsection



<script>
  

  function volcarSelects(emisor, receptor){
    
    // Accedemos a los 2 selects
    emisor = document.getElementById(selectorI);
    receptor = document.getElementById(selectorI2);
    
    // Obtenemos algunos datos necesarios
    posicion = receptor.options.length;
    selecionado = emisor.selectedIndex;
    
    if(selecionado != -1) {

        volcado = emisor.options[selecionado];
        
        // Volcamos la opcion al select receptor y lo eliminamos del emisor
        receptor.options[posicion] = new Option(volcado.text, volcado.value);
        emisor.options[selecionado] = null;

    }
  
  }


</script>
=======
@endsection
>>>>>>> a7a3c3a05b5d28c26fcc4fd5a6525fc174f6e9e3
