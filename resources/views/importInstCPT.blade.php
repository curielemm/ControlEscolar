@extends('layouts.app')
<title>Importar desde CSV</title>
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Importar desde CSV</title>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />-->
</head>

<body>
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Importar Instituciones Capacitación para el Trabajo
        </div>

        <div class="card-body">
            <form action="{{ route('importInstCPT') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Importar Instituciones Capacitación para el Trabajo</button>
                <a class="btn btn-warning" href="{{ route('exportInstCPT') }}">Exportar Instituciones Capacitación para el Trabajo</a>

            </form>
                @yield('csv_data')
        </div>
    </div>
</div>
   
</body>

</html>
@endsection