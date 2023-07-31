<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@extends('layouts.app')
<title>Registro Calificaciones</title>
@section('content')

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
  </style>


<style>
  .table-responsive,
  .tabla-responsive-lg,
  .tabla-responsive-md,
  .tabla-responsive-sm,
  .tabla-resposive-xl {
    max-width: 650px;
  }

  .table {
    width: 40%;
    margin-bottom: 1rem;
    color: #212529;
    background: white;
  }
</style>
<div class="row" >
    <div class="col-md-7 offset-md-2">
        <div class="card card-default">
            <div class="card-heading">
              <center>
                <h2>REGISTRO DE CALIFICACIONES ASIGNATURA:</h2>
                <center>
            </div>


            <div class="card-body" >
                <form   method="post" action="" >
                {{csrf_field()}}
                 <center><label class="control-label col-sm-11" id="obligatorios" >*Datos  obligatorios</label></center>
                    
                    
                   <div class="container">
                      <div class="row">
                        <div class="col-xs-12 col-md-12">
                          <div class="form-group two-fields">
                            <div class="input-group">
                              <label class="control-label col-sm-0" id="asterisco">*</label>
                              <label class="control-label col-sm-6">PARCIAL 1:</label>
                              
                                <div class="col-sm-8">
                             
                            <input type="text"  class="form-control" name="matricula" id="matricula" placeholder="CALIFCACIÓN PARCIAL 1">
                           
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
                              <label class="control-label col-sm-6">PARCIAL 2:</label>
                              
                                <div class="col-sm-8">
                             
                            <input type="text"  class="form-control" name="matricula" id="matricula" placeholder="CALIFCACIÓN PARCIAL 2">
                           
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
                              <label class="control-label col-sm-6">PARCIAL 3:</label>
                              
                                <div class="col-sm-8">
                             
                            <input type="text"  class="form-control" name="matricula" id="matricula" placeholder="CALIFCACIÓN PARCIAL 3">
                           
                           </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>


                    <div class="col-sm-offset-2 col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block">GUARDAR CALIFICACIONES</button>
                    </div>



      </form>
                      </div>




                    </div>
                      </div>
                  </div>
             

@endsection

