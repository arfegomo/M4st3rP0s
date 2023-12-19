<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransactionsTable extends Migration
{

    public function up()
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('impuesto_id')->constrained('impuestos');
            $table->float('cantidad');
            $table->float('descuento');
            $table->float('preciounitario');
            $table->float('impuesto');
            $table->float('baseunitario');
            $table->float('costoventa');
            $table->float('referencia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transactions');
    }
}
