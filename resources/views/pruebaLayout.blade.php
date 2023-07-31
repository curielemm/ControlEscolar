@extends('layouts.app')

@section('content')
<input type="button" id="add_field" value="adicionar">
<br>
<div id="listas">
    <div><input type="text" name="campo[]"></div>
</div>


<script>
    var campos_max = 20; //max de 10 campos

    var x = 0;
    $('#add_field').click(function(e) {
        e.preventDefault(); //prevenir novos clicks
        if (x < campos_max) {
            $('#listas').append('<div>\
                        <input type="text" name="campo[]">\
                        <a href="#" class="remover_campo">Remover</a>\
                        </div>');
            x++;
        }
    });
    // Remover o div anterior
    $('#listas').on("click", ".remover_campo", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
</script>
@endsection