<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@extends('layouts.app')
<title>Agregar Ciclo Escolar</title>

<script type="text/javascript">
    $(':radio').on('click', function() {
        document.querySelectorAll('[name=Tipo]').forEach((x) => x.checked = false);
    });
</script>
@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-default">
            <div class="card-heading">
                <br>
                <center>
                    <h4>INGRESE LOS DATOS DEL CICLO ESCOLAR </h4>

                    <h5>* Campos Obligatorios</h5>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    @if(session()->has('message2'))
                    <div class="alert alert-danger">
                        {{ session()->get('message2') }}
                    </div>
                    @endif
                    <center>
            </div>
            <div class="card-body">
                <form action="{{route('agregarCi')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">* Ciclo Escolar:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{old('id_ciclo_escolar')}}" maxlength="15" placeholder="Ejemplo: 2020-2021" name="id_ciclo_escolar" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            {!! $errors->first('id_ciclo_escolar','<small class="text-danger">:message</small><br>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">* Fecha Inicio:</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" value="{{old('fecha_inicio')}}" minlenght="1" maxlength="12" name="fecha_inicio" id="fecha_inicio" onchange="pasar();">
                            {!! $errors->first('fecha_inicio','<small class="text-danger">:message</small><br>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">* Fecha Final:</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" value="{{old('fecha_fin')}}" minlenght="1" maxlength="12" name="fecha_fin" id="fecha_fin">
                            {!! $errors->first('fecha_fin','<small class="text-danger">:message</small><br>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">* ¿Ciclo Escolar Actual?</label>
                        <div class="col-sm-2">
                            <input type="radio" value="1" minlenght="1" maxlength="12" name="actual">
                            <label for="">Si</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="radio" value="0" minlenght="1" maxlength="12" name="actual">
                            <label for="">No</label>
                        </div>
                    </div>


                    <center>
                        <div class="col-sm-10">

                            <button type="submit" class=" btn btn-success">Agregar Ciclo Escolar</button>
                        </div>
                    </center>
                </form>

            </div>





            <div class="card-body">
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class=" btn btn btn-danger"><span class="fa fa-home" aria-hidden="true">Regresar al Panel </span>
                    </form>
                </div>

            </div>

        </div>


    </div>
</div>

<script>
  function valor() {
    date = new Date($('#fecha_inicio').val())
    date.getDate()
  }

  $('#fecha_inicio').on('change', function() {
    var date = new Date($('#fecha_inicio').val());
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
   // alert([day, month, year].join('/'));
  });

  function ValidarFechas() {
    var fechainicial = document.getElementById("fecha_inicio").value;
    var fechafinal = document.getElementById("fecha_fin").value;

    if (fechafinal.year > fechainicial.year || fechafinal.month > fechainicial.month || fechafinal.day > fechainicial.day)

     // alert("La fecha final debe ser mayor a la fecha inicial");

  }

  $(document).ready(function() {
    $("#fecha_inicio").datepicker({
      minDate: 0,
      maxDate: "+60D",
      numberOfMonths: 2,
      onSelect: function(selected) {
        $("#fecha_fin").datepicker("option", "minDate", selected)
      }
    });

    $("#fecha_fin").datepicker({
      minDate: 0,
      maxDate: "+60D",
      numberOfMonths: 2,
      onSelect: function(selected) {
        $("#fecha_inicio").datepicker("option", "maxDate", selected)
      }
    });
  });
</script>

<script>
    function pasar() {
        var value = $("#fecha_inicio").val();
        $("#fecha_fin").attr("min", value);
    }
</script>

@endsection