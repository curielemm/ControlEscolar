@extends('import')

@section('csv_data')

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Clave Director</th>
			<th>Nombre</th>
			<th>A. Paterno</th>
			<th>A. Materno</th>
			<th>Correo</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($data as $row)
		<tr>
		<td>{{$row->clave_director}}</td>
		<td>{{$row->nombre_pila}}</td>
		<td>{{$row->apellido_paterno}}</td>
		<td>{{$row->apellido_materno}}</td>
		<td>{{$row->correo}}</td>
        </tr>
		@endforeach
	</tbody>
</table>

{!! $data->links() !!}

@endsection