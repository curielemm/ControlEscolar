<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha Tecnica</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
        <h2 class="text-center">INFORMACIÓN DE {{$uno->nombre_institucion}}</h2>
        <div>css</div>
    </header>


    <div>
        <h4> Dirección: Calle {{$uno->calle}} @if($uno->numero_interior =! null) Número Interior {{$uno->numero_interior }} @endif Número Exterior {{$uno->numero_exterior}}
            Colonia {{$uno->colonia}} {{$uno->codigo_postal}} {{$uno->municipio}}, OAX.</h4>
    </div>
    <p></p>
    <div>
        <h4> {{$uno->nombre_tipo_directivo}}: {{ $uno->directivo_autorizado}}</h4>
    </div>
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

    <div class="container-fluid">

        <table class="table  table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo de Capacitación para el Trabajo</th>
                    <th>Rvoe</th>
                    <th>Descripción</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach($datos as $planes)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$planes->nombre_nivel_educativo}}</td>
                    <td>{{$planes->rvoe}}</td>
                    <td>{{$planes->descripcion}}</td>
                    <td>{{$planes->nombre_status}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <footer>
        <p><strong></strong></p>
    </footer>
</body>

</html>
