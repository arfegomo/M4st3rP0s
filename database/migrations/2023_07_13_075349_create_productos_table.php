<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{

    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->double('costoinicial')->nullable();
            $table->double('costoactual')->nullable();
            $table->double('existenciainicial')->nullable();
            $table->double('existenciactual')->nullable();
            $table->tinyInteger('facturable');
            $table->tinyInteger('habilita');
            $table->double('stockminimo')->nullable();
            $table->double('stockmaximo')->nullable();
            $table->double('precioventa1')->nullable();
            $table->double('precioventa2')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
