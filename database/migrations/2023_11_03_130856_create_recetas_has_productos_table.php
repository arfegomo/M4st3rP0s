<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasHasProductosTable extends Migration
{

    public function up()
    {
        Schema::create('recetas_has_productos', function (Blueprint $table) {
            $table->foreignId("producto_id")->constrained("productos");
            $table->foreignId("receta_id")->constrained("recetas");
            $table->double("cantidad");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recetas_has_productos');
    }
}
