@extends('layouts.app')
<title>Materias</title>
@section('content')

<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>ID Materia</th>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Tipo Periodo</th>
                            <th>Acciones</th>
                        </tr>
                    <tbody>
                        @foreach($materia as $materia)
                        <tr>

                            <td>{{$materia->id_materia}}</td>
                            <td>{{$materia->nombre}}</td>
                            <td>{{$materia->carrera}}</td>
                            <td>{{$materia->tipo_periodo}}</td>
                            <td>

                                    <button type="submit" class=" btn-success btn-block" >Editar</button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    </thead>
                </table>

                  <center>
                <div class="col-sm-offset-0 col-sm-10">
                 <form action="{{route('dashboardAnalista')}}" method="get">
                     {{csrf_field()}}
                     <button type="submit" class=" btn-success" >Panel de Control</button>
                 </form>
               </div>
             </center>

                 <center>
                <div class="col-sm-offset-0 col-sm-10">
                 <form action="{{route('formularioalumnos')}}" method="get">
                     {{csrf_field()}}
                     <button type="submit" class=" btn-danger" >Agregar Alumno(a)</button>
                 </form>
               </div>
               <center>
            </div>
        </div>
    </div>
</div>

@endsection
