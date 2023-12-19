<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporariessTable extends Migration
{

    public function up()
    {
        Schema::create('temporaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consecutivo_id')->constrained('consecutivos');
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('impuesto_id')->constrained('impuestos');
            $table->foreignId('concepto_id')->constrained('conceptos');
            $table->foreignId('documento_id')->constrained('socio_negocios');
            $table->float('cantidad');
            $table->float('descuento');
            $table->float('preciounitario');
            $table->float('impuesto');
            $table->float('baseunitario');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporaries');
    }
}
