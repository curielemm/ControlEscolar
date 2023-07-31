@extends('layouts.app')
<title>Datos Excel</title>
@section('content')


<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">

            <h3 class="text-center">AGREGAR DATOS DE ALUMNOS DE @if($datos->id_tipo_nivel==1){{$datos->nombre_plan}} {{$datos->vigencia}} @endif
                @if($datos->id_tipo_nivel!=1){{$datos->nombre_nivel_educativo}} @endif</h3>
            <div class="card-header">

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
            </div>
            {!! $errors->first('matricula','<small class="text-danger">:message</small><br>') !!}

            <div class="card-body">
                <div class="form-inline pull-right">
                    <a href="{{Storage::url($url)}}" type="submit" class="btn btn-primary"><span class="fa fa-download" aria-hidden="true"> Descargar Formato</span></a>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>

                </div>

                <div>
                    <form action="{{route('importExcel')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">* Grupo:</label>
                            <div class="col-sm-9">
                                <select id="clave_grupo" title="option" name="clave_grupo" class="form-control" required>
                                    @foreach($grupos as $g)
                                    <option id="opciones" class="form-control" value="{{$g['clave_grupo']}}">
                                        {{$g['no_periodo'] }} {{$g['nombre_grupo']}}
                                    </option>@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-control">
                            <input type="file" name="file" id="file" accept=".csv" required>
                        </div>
                        <div> <input type="text" name="rvoe" value="{{$rvoe}}" style="visibility:hidden">
                            <input type="hidden" name="vigencia" id="vigencia" value="{{$datos->vigencia}}">
                        </div>
                        <div class="form-control">
                            <button type="submit" class=" btn-success btn-block">Aceptar</button>
                        </div>
                    </form>
                </div>
                <div>
                    <form method="get" action="{{'/panel'}}">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-home" aria-hidden="true">Regresar a Panel </span>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection