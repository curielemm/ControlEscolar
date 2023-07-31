<!DOCTYPE html>
<html lang="en">

<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="/img/logocg2.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/titles.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
      position: relative;
    }

   

    #divizq {
      position: absolute;
      top: 0.5cm;
      left: 30cm;
      right: 0cm;

    }

    #divizq2 {
      position: absolute;
      top: 0.7cm;
      left: 13cm;
      color: white;
    }
  </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
    <a class="navbar-brand" href="https://www.oaxaca.gob.mx/cgemsyscyt/"><img width="300" height="50" src="/img/logocg.png"></a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/panel">Panel de Control</a>
      </li>
      <li class="nav-item">
        <div id="divizq2" name="divizq2" class=""></div>
        <input type="hidden" name="clave_cct" id="clave_cct" value="{{auth()->user()->institucion}}">
      </li>
      <li class="nav-item">
        <div id="divizq">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            Cerrar Sesión
          </a>
        </div>
      </li>
      <!--li class="nav-item">
        <a class="nav-link" href="#section3">Section 3</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Section 4
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#section41">Link 1</a>
          <a class="dropdown-item" href="#section42">Link 2</a>
        </div>
      </li -->
    </ul>
  </nav>

  <div id="divConta" class="container">
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <hr>
    <hr>
    <hr>
    <hr>
    @yield('content')
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Listo para Salir?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <form method="POST" action="{{route('logout')}}">

              {{csrf_field()}}
              <button class="btn btn-danger btn-xs btn-block">Cerrar Sesión</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <hr>
    <hr>
    <hr>
    <hr>
  </div>
  
</body>
<script>
  $('.alert').alert()
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var clave_cct = $('#clave_cct').val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'POST',
      url: '/data',
      data: {
        "clave_cct": clave_cct
      },
      success: function(data) {
        $('#divizq2').append(data['nombre_institucion']);
      }
    });
    // });
  });
</script>

</html>