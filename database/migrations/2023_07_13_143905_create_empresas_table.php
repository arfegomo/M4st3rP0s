<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{

    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('nit');
            $table->integer('digitoverificacion');
            $table->string('direccion');
            $table->foreignId('ciudad_id')->constrained('ciudades');
            $table->integer('consecutivo');
            $table->integer('telefono');
            $table->string('celular');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
