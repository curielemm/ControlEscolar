@extends('layouts.app')
<title>Kardex</title>
@section('content')

<link rel="stylesheet" type="text/css" href="css/kardex.css">

<div class="container">
    <div class="row">
        <div class="card card-default">

            <header>
              <h2>NOMBRE DE LA ESCUELA</h2>
              <h0>CLAVE CCT DE LA ESCUELA</h0>
             <br>
              <h5>KARDEX DEL ALUMNO</h5>

              <h3>CARRERA DEL ALUMNO </h3>


              </header>
            <body>
               <nav>

             <a  href="/">Regresar Al Panel</a>
              <a  href="/">Alumnos</a>
              <a  href="/">Salir</a>
              <a  href="/">Ver Materias</a>
               </nav>
       <br>

             <section>
       <table class="table table-light table-hover table-striped">

               <tr>
                   <th>Nombre</th>
                   <th>Apellido Paterno</th>
                   <th>Apellido Materno</th>

                 </tr>
                 <tr>
                  <td>Gelasio</td>
                  <td>Ramirez</td>
                  <td>Garcia</td>
                </tr>
                <tr>
                    <th>Matricula</th>
                    <th>Sexo</th>

                  </tr>
                  <tr>
                   <td>14161331</td>
                   <td>MASCULINO</td>
                 </tr>

                 <tr>
                     <th>Observaciones</th>

                   </tr>
</table>
      </section>

<br>
<nav2>
<table class="table table-light table-hover table-striped">
    <thead class="thead-light">

      <tr>

          <th colspan="3">JALAR PERIODO </th>
          <th></th>
          <th></th>
          <th>EVAL</th>
          <th></th>
          <th></th>
          <th colspan="2">EXAMEN </th>
          <th></th>
          <th>GRUPO</th>
          <td>JalarGrupo</td>

        </tr>

        <tr>
            <th colspan="3">PERIODO ESCOLAR </th>
            <td>JalarPeriodo</td>

            <th></th>
            <th colspan="2">PARCIALES</th>
            <th>PROM</th>
            <th colspan="2">ORDINARIO</th>
            <th colspan="3">EXAMEN REGULARIZACION</th>

          </tr>

          <tr>
              <th></th>
              <th></th>
              <th></th>
              <th>CLAVE</th>
              <th>SERIACION</th>
              <th>I</th>
              <th>II</th>
              <th>PARCIAL</th>
              <th>CALIF</th>
              <th>FECHA</th>
              <th>CALIF</th>
              <th>TIPO</th>
              <th>FECHA</th>

            </tr>


        <tr>

           <td>JALARMATERIA</td>
            <td></td>
             <td></td>
           <td>JALAR</td>
           <td></td>
           <td>JALAR</td>
           <td>JALAR</td>
           <td>JALAR</td>
           <td>JALAR</td>
           <td>JALARFECHA</td>
         </tr>

         <tr>

            <td>FISICA</td>
             <td></td>
              <td></td>
            <td>FIS012</td>
            <td></td>
            <td>7</td>
            <td>7</td>
            <td>7.00</td>
            <td>7</td>
            <td>25/11/2019</td>
          </tr>

          <tr>
            <td>INLGES II</td>
             <td></td>
              <td></td>
            <td>ING02</td>
            <td>ING01</td>
            <td>8</td>
            <td>7</td>
            <td>7.5</td>
            <td>8</td>
            <td>26/11/2019</td>
          </tr>

          <tr>
            <td>HISTORIA DEL DERECHO MEXICANO</td>
             <td></td>
              <td></td>
            <td>HIS01</td>
            <td></td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>26/11/2019</td>
          </tr>

                   </table>

</nav2>
<nav3>
<label >ELABORO:</label>
<label >__________ </label>
</nav3>





               <center>
            <div class="card-body">
               <a type="button" class="btn btn-info" href="/">Imprimir</a>
            </div>
          </center>
        </div>
    </div>
</div>
@endsection
