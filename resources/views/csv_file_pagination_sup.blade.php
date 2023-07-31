@extends('importInstSup')

@section('csv_data')

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Clave CCT</th>
			<th>Nombre Institución</th>
			<th>Código Postal</th>
			<th>Colonia</th>
			<th>Municipio</th>
			<th>Tipo de Directivo</th>
			<th>Nombre Directivo Autorizado</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($data as $row)
		<tr>
		<td>{{$row->clave_cct}}</td>
		<td>{{$row->nombre_institucion}}</td>
		<td>{{$row->codigo_postal}}</td>
		<td>{{$row->colonia}}</td>
		<td>{{$row->municipio}}</td>
		<td>{{$row->id_tipo_directivo}}</td>
		<td>{{$row->directivo_autorizado}}</td>
        </tr>
		@endforeach
	</tbody>
</table>

{!! $data->links() !!}

@endsection