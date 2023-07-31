<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha Tecnica</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <style type="text/css">
        @page {
            margin: 0cm 0cm;
            font-size: 2.5mm;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            background-color: white;
            color: black;
            text-align: center;
            line-height: 30px;



        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C668;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        #content {
            position: fixed;
        }

        #content img {
            position: fixed;
            top: 0px;
            right: 900px;

        }
    </style>

</head>

<body>
    <header>

        <div id="content">
            <img src="{{ public_path('img\logocg.png') }}" width="200" height="50">
        </div>
        <h1 class="text-center">{{$uno->nombre_institucion}}</h1>
        <h2 class="text-center">CLAVE: {{$uno->clave_cct}}</h2>
        <h1 class="text-center">FICHA TÉCNICA</h1>
        <h1 class="text-center">{{$plan->nombre_plan}}</h1>
        <h2 class="text-center">RVOE: {{$plan->rvoe}}</h2>
        <h3 class="text-center">CICLO ESCOLAR:{{$ciclo}} </h3>
        <h4 class="text-center">MODALIDAD:{{ $plan->nombre_modalidad}}</h4>

    </header>

    <p></p>
    <div>
        <h4> Matrícula Total: {{$matriculaTotal}} </h4>
    </div>
    <p></p>
    <div>
        <h4> Matrícula Mujeres: {{$matriculaMujeres}}</h4>
    </div>
    <p></p>
    <div>
        <h4>Matrícula Hombres: {{$matriculaHombres}}</h4>
    </div>
    <p></p>


    <div class="text-center"> <img src="{{$data}}"  width="500" height="500">
    </div>
    <footer>
        <p><strong></strong></p>
    </footer>
</body>

</html>
