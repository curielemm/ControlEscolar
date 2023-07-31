@extends('layouts.app')
<title>Asignar Instituciones</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card card-default">
            <h3 class="text-center">Seleccione un analista y las instituciones para asignar</h3>
            <div class="card-body">
                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <form method="POST" action="{{ route('asignar') }}">
                    @csrf

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Analistas:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="analista">
                            @foreach($analistas as $a)
                            <option value="{{$a->clave_usuario}}">{{$a->nombre_usuario}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Instituciones:</label>
                        <select style="width: 1070px;" class="js-example-basic-multiple" name="instituciones[]" multiple="multiple">
                            @foreach($instituciones as $ins)
                            <option value="{{$ins->clave_cct}}">{{$ins->nombre_institucion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-4 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Asignar') }}
                            </button>
                        </div>
                    </div>


                </form>

                <a href="{{'/panel'}}">Regresar al Panel de Control</a>
            </div>
        </div>


    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: 'seleccione una opcion'
        });
    });
</script>
@endsection
