<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <style>
    body {
      position: relative;
    }

    footer {
      position: fixed;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 2.2cm;
      background-color: gray;
      color: white;
      text-align: center;
      line-height: 35px;
    }

    .pie {
      position: absolute;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 3.6cm;
      background-color: gray;
      color: white;
      text-align: justify;
      line-height: 35px;
    }
  </style>
  <title>CGEMSySCyT-Plataforma</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="1000">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
    <a class="navbar-brand" href="https://www.oaxaca.gob.mx/cgemsyscyt/"><img width="300" height="50" src="/img/logocg.png"></a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/panel">Panel de Control</a>
      </li>
    </ul>
  </nav>
  <div class="container-fluid">
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <hr>
    <hr>
    <hr>
    <hr>
    <div class="card">
      <div class="card-image"></div>
      <div class="card-text">
        <span class="date">Usuario</span>
        <h2>Administrador</h2>
        <p></p>
      </div>
      <div class="card-stats">
        <div class="stat">
          <div class="type">
            <form action="{{ route('loginAdmin')}}" method="GET"><button type="submit" id="btnAdmin">Ingresar</button></form>
          </div>
        </div>

      </div>
    </div>
    <div class="card">
      <div class="card-image card2"></div>
      <div class="card-text card2">
        <span class="date">Usuario</span>
        <h2>Analista</h2>
        <p></p>
      </div>
      <div class="card-stats card2">
        <div class="stat">
          <div class="type">
            <form action="{{ route('loginAnalista')}}" method="GET"><button type="submit" id="btnCapturista">Ingresar</button></form>
          </div>
        </div>

      </div>
    </div>
    <div class="card">
      <div class="card-image card3"></div>
      <div class="card-text card3">
        <span class="date">Usuario</span>
        <h2>Servicios Escolares</h2>
        <p></p>
      </div>
      <div class="card-stats card3">
        <div class="stat">

          <div class="type">
            <form action="{{ route('login')}}" method="GET"><button type="submit" id="btnServEsc">Ingresar</button></form>
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
    <hr>
    <hr>
  </div>
  <footer>
    <p><strong>
        <p class="info">Coordinación General de Educación Media Superior y Superior, Ciencia y Tecnología CCT: 20ADG0101A Flor de Azahar No. 200, Fraccionamiento Valle de los Lirios, Ex Hacienda Candiani, Oaxaca de Juárez Oax. C.P. 68125.</p>
      </strong></p>
  </footer>

</body>

</html>