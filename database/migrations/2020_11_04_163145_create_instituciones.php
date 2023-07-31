<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->string('clave_cct')->primary();
            $table->string('clave_dgpi');
            $table->string('nombre_institucion');
            $table->string('municipio');
            $table->integer('codigo_postal');
            $table->string('colonia');
            $table->string('calle');
            $table->integer('numero_interior');
            $table->integer('numero_exterior');
            $table->string('directivo_autorizado');
            $table->string('reglamento_institucional');
            $table->string('manual_organizacion');
            $table->string('pagina_web');
            $table->integer('id_tipo_directivo');

            $table->foreign('clave_cct')->references('institucion_plan')->on('instituciones');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instituciones');
    }
}
