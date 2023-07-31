<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
        <a class="navbar-brand" href="https://www.oaxaca.gob.mx/cgemsyscyt/"><img width="300" height="50" src="/img/logocg.png"></a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <hr>
        <hr>
        <hr>
        <hr>
        @yield('content')
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <hr style=" visibility: hidden;">
        <hr style=" visibility: hidden;">
        <hr style=" visibility: hidden;">
        <hr style=" visibility: hidden;">
    </div>
    <footer>
        <p><strong>
                <p class="info">Coordinación General de Educación Media Superior y Superior, Ciencia y Tecnología CCT: 20ADG0101A Flor de Azahar No. 200, Fraccionamiento Valle de los Lirios, Ex Hacienda Candiani, Oaxaca de Juárez Oax. C.P. 68125.</p>
            </strong></p>
    </footer>
</body>

</html>