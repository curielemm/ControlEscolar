@extends('layouts.app')
<title>Registro Alumnos</title>
@section('content')
<html>

<style>
  .container,
  .container-lg,
  .container-md,
  .container-sm,
  .container-xl {
    max-width: 2000px;
  }

  .table {
    width: 150%;
    margin-bottom: 1rem;
    color: #212529;
    background: white;
  }

#txtCurp{
    background-color: red;
    color: white;
   
}
#txtCurp.ok {
    background-color: green;
}

  
</style>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Materias</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body  class="bg-black">
  <div class="container" >
     <br />
     <h1 align="center" class="text-white"> Registro de Alumnos </h1>
     <br />
   <div class="table-responsive" >
                <form method="post" id="dynamic_form" class="bg-secondary">
                 <span id="result"></span>
                 <table class="table table-bordered table-striped" id="user_table" background="white"
                 >
               <thead >
                <tr>
                    <th  width="5%">Grupo</th>
                    <th  width="4%">Matricula</th>
                    <th  width="4%">Nombre</th>
                    <th  width="4%">A. Materno</th>
                    <th  width="4%">A. Paterno</th>
                    <th  width="1%">Fecha Nacimiento</th>
                    <th  width="4%">CURP</th>
                    <th  width="6%">Correo</th>
                    <th  width="1%">Acciones</th>
                </tr>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                <tr>
                                <td colspan="8" align="right">&nbsp;</td>
                                <td>
                  @csrf
                  <input type="submit" name="save" id="save" class="btn btn-primary" value="Guardar" />
                 </td>
                </tr>

               </tfoot>
           </table>

                  
   </div>
  </div>

  <a href="InstitucionDinamico" class="btn btn-success  active" role="button" aria-pressed="true">Inicio de proceso</a>
 </body>
</html>

<script>
$(document).ready(function(){

 var count = 1;

 dynamic_field6(count);

$(function(){
    $(document).on('input','#txtCurp.form-control',function(){ //detectamos el evento change
      
    });
  });


 function dynamic_field6(number)
 {
  html = '<tr>';

        html += '<td><select name="clave_grupo[]" class="form-control">@foreach($grupo as $gpo)<option id="opciones" class="form-control"  value={{$gpo['clave_grupo']}}> {{$gpo['nombre_grupo']}} </option>@endforeach<option hidden selected>Selecciona una opción</option></select></td>';

        html += '<td><input type="text" name="matricula[]" class="form-control" /></td>';
        html += '<td><input type="text" name="nombre[]" class="form-control" /></td>';
        html += '<td><input type="text" name="apellido_paterno[]" class="form-control" /></td>';
        html += '<td><input type="text" name="apellido_materno[]" class="form-control" /></td>';
        html += '<td><input type="Date" name="fecha_nacimiento[]" class="form-control" /></td>';
        html += '<td><input type="text"  id="txtCurp"  name="curp[]" maxlength="18" class="form-control" oninput="validarInput(this)"/></td>';

        html += '<td><input type="text" name="correo[]" class="form-control" /></td>';
 

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

  $(function(){
    $(document).on('input','#txtCurp.form-control',function(){ //detectamos el evento change
      validarInput(this);
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
 });

});
</script>
@endsection
<script>
  
  //Función para validar una CURP
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);
  
    if (!validado)  //Coincide con el formato general?
      return false;
    
    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;

      if (lngDigito == 10) return 0;
        return lngDigito;
    }
  
    if (validado[2] != digitoVerificador(validado[1])) 
      return false;
        
    return true; //Validado
}

//Handler para el evento cuando cambia el input
//Lleva la CURP a mayúsculas para validarlo
function validarInput(input) {
    var curp = input.value.toUpperCase(),
        resultado = document.getElementById('txtCurp'),
        valido = "No válido";
        
    if (curpValida(curp)) { // ⬅️ Acá se comprueba
      valido = "Válido";
        resultado.classList.add("ok");
    } else {
      resultado.classList.remove("ok");
    }
        
    //resultado.innerText = "CURP: " + curp + "\nFormato: " + valido;
}


</script>