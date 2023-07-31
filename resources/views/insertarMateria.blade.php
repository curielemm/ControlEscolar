<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@extends('layouts.app')
<title>Registro Materias</title>
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

<div class="row" >
    <div class="col-md-7 offset-md-2">
        <div class="card card-default">
            <div class="card-heading">
              <center>
                <h2>REGISTRO DE ASIGNATURAS</h2>
                <center>
            </div>


            <div class="card-body" >
                <form   method="post" action="{{ route('registroMateria')}}" >
                {{csrf_field()}}
                 <center><label class="control-label col-sm-11" id="obligatorios" >* Datos  obligatorios</label></center>
               <div class="container">
                      <div class="row">
                        <div class="col-xs-12 col-md-12">
                          <div class="form-group two-fields">
                            <div class="input-group">
                              <label class="control-label col-sm-12">Institución:</label>
                               <div class="col-sm-offset-2 col-sm-12">
                       <div>
                          @foreach($escuela as $e)
                            <input type="text"  class="form-control" name="nombre_institucion" value="{{$e['nombre_institucion']}}" readonly>
                            @endforeach

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
                              <label class="control-label col-sm-12">Plan de Estudio:</label>
                               <div class="col-sm-offset-2 col-sm-12">
                       <div>
                          @foreach($plan as $p)
                            <input type="text"  class="form-control" name="nombre_plan" value="{{$p['nombre_plan']}}" readonly>
                            @endforeach

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
                              <label class="control-label col-sm-6">RVOE Plan de Estudio:</label>
                              <label class="control-label col-sm-0" id="asterisco">*</label>
                              <label class="control-label col-sm-5">Clave de Asignatura:</label>
                                <div class="col-sm-6">
                               @foreach($plan as $p)
                            <input type="text"  class="form-control" name="fk_rvoe" id="fk_rvoe" value="{{$p['rvoe']}}" readonly>
                            @endforeach
                           </div>
                                         <span class="input-group-addon"></span>
                            <div class="col-sm-6">
                              <input type="text" class="form-control"  placeholder="Clave de Asignatura" name="clave_asignatura" id="clave_asignatura" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('clave_asignatura')}}" required maxlength="10">
                              {!!$errors->first('clave_asignatura','<small class="text-danger">:message</small><br>')!!}
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
                              <label class="control-label col-sm-11">Nombre de la Asignatura:</label>
                              
                               <div class="col-sm-offset-2 col-sm-12">
                       
                          <input type="text" class="form-control"  placeholder="Nombre de la Asignatura" name="nombre_asignatura" id="nombre_asignatura" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('nombre_asignatura')}}" required maxlength="30">
                          {!!$errors->first('nombre_asignatura','<small class="text-danger">:message</small><br>')!!}
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
                              <label class="control-label col-sm-11">Tipo de Asignatura:</label>
                              
                               <div class="col-sm-offset-2 col-sm-12">
                       
                         <select name="tipo_asignatura" id="tipo_asignatura" class="form-control" required>
                              <option value="SELECCIONE"  selected>SELECCIONE UNA OPCIÓN</option>
                              <option value="tronco_comun">TRONCO COMÚN</option>
                              <option value="especialidad">ESPECIALIDAD</option>
                            </select>
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

                              <label class="control-label col-sm-6">Número de Periodo:</label>
                              <label class="control-label col-sm-0" id="asterisco">*</label>
                              <label class="control-label col-sm-5">Periodo Académico:</label>
                                <div class="col-sm-6">
                              
                            <input type="text"  class="form-control" name="no_periodo" id="no_periodo"value="{{old('no_periodo')}}" placeholder="Numero de Periodo (1-13)">

                        
                           </div>
                          <span class="input-group-addon"></span>
                            <div class="col-sm-6">
                              <!--<input type="text" class="form-control"  placeholder="Periodo Académico" name="periodo" id="periodo" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('periodo')}}" required maxlength="2">-->
                           
                            <select name="semestre_cuatrimestre" id="semestre_cuatrimestre" class="form-control" required>
                              <option value="SELECCIONE">SELECCIONE UNA OPCIÓN</option>
                              <option value="SEMESTRE">SEMESTRE</option>
                              <option value="CUATRIMESTRE">CUATRIMESTRE</option>
                              <option value="TRIMESTRE">TRIMESTRE</option>
                              <option value="BIMESTRE">BIMESTRE</option>
                            </select>

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
                              <label class="control-label col-sm-6">Seriazión:</label>
                              <label class="control-label col-sm-0" id="asterisco">*</label>
                              <label class="control-label col-sm-5">No. Creditos:</label>
                                <div class="col-sm-6">
                              
                            <!--<input type="text"  class="form-control" name="seriazion" id="seriazion"value="{{old('seriazion')}}" placeholder="Clave de Asignatura o N/A">-->

                            <select id="seriazion" title="option" name="seriazion" class="form-control" >@foreach($asignatura as $a)<option id="opciones" class="form-control"  value="{{$a->clave_asignatura}}">{{$a->nombre_asignatura}}</option>@endforeach
                            <option hidden selected>Seriazión</option>
                          </select>
                           </div>
                                         <span class="input-group-addon"></span>
                            <div class="col-sm-6">
                              <input type="text" class="form-control"  placeholder="No. Creditos" name="no_creditos" id="no_creditos" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('no_creditos')}}" required maxlength="2">
                              {!!$errors->first('no_creditos','<small class="text-danger">:message</small><br>')!!}
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
                              <label class="control-label col-sm-6">Clave de Seriazión:</label>
                              <label class="control-label col-sm-0" id="asterisco">*</label>
                              <label class="control-label col-sm-5">No. de Parciales:</label>
                                <div class="col-sm-6">
                              
                            <input type="text"  class="form-control" name="clave_seriacion" id="clave_seriacion"value="{{old('clave_seriacion')}}" placeholder="Clave de Seriazión">
                        
                           </div>
                            <span class="input-group-addon"></span>
                            <div class="col-sm-6">

                              <input type="text" class="form-control"  placeholder="No. de Parciales" name="no_parciales" id="no_parciales" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{old('no_parciales')}}" required maxlength="2">
                           
                          </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>





                    <div class="col-sm-offset-2 col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block">Registrar Asignatura</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
  $( function() {
    $("#no_periodo").keyup( function() {
        if ($(this).val() === "1") {
            $("#seriazion").prop("disabled", true);
            $("#clave_seriacion").prop("disabled", true);

        } else {
            $("#seriazion").prop("disabled", false);
            $("#clave_seriacion").prop("disabled", false);

        }
    });
});

</script>