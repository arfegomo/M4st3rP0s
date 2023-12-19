<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concepto_id')->constrained('conceptos');
            $table->foreignId('documento_id')->constrained('socio_negocios');
            $table->foreignId('user_id')->constrained('users');
            $table->string('fecha');
            $table->string('hora');
            $table->string('estado');
            $table->integer('consecutivo');
            $table->string('observacion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
