<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="icon" type="image/png" href="/img/logocg2.png" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <style type="text/css">
    body {
      background: url("/img/fondo_textura.png")fixed #222;

    }

    .cabecera {
      background: black;
      background-image: url("../img/fondo_textura.png") fixed #222;


    }

    #imgTop {
      float: left;
    }

    #imgTop2 {
      float: right;
    }

    .linea {
      opacity: .9;
      width: 100%;
      height: auto;
    }

    .ubicacion {
      width: 35%;
      height: 150px;
      border: none;
      float: center;
      opacity: .8;
      font-family: roboto;
      text-align: justify;
      margin: 20px;
    }

    .pie_pagina {
      margin-top: 50px;
      background: #572364;
      background-image: url("../img/fondo-footer-gris.png");
      color: white;
      width: 100%;
      height: 220px;

    }
  </style>

</head>

<body>
  <div class="cabecera" id="cabecera1">


    <section id="imgTop">
      <img src="/img/CGEMSySCyT.png" width="280" height="120">
    </section>

    <section id="imgTop2">
      <img src="/img/serpiente_oaxaca.png" width="700" height="145">
    </section>


  </div>

  <div class="linea" id="linea">
    <section id="lineacolor">
      <img src="/img/barra-colores-footer.png" width="100%" height="35">
    </section>
  </div>
  <div class="container">
    <hr>
    @yield('content')
  </div>
  <div></div>
  <div class="pie_pagina" id="pie_pagina1">

    <div class="linea" id="linea">
      <section id="lineacolor">
        <img src="/img/barra-colores-footer.png" width="100%" height="35">
      </section>
    </div>

    <section id="ubicacion">
      <section class=".ubicacion">
        <center>
          <h2>Ubicación</h2>
        </center>
        <p class="info">Coordinación General de Educación Media Superior y Superior, Ciencia y Tecnología CCT: 20ADG0101A Flor de Azahar No. 200, Fraccionamiento Valle de los Lirios, Ex Hacienda Candiani, Oaxaca de Juárez Oax. C.P. 68125.</p>
        <p class="info"> </p>
      </section>

      <section class="mapa">
        <h2></h2>
      </section>
    </section>


  </div>
</body>

</html>