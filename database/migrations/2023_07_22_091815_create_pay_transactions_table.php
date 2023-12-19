<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayTransactionsTable extends Migration
{
    
    public function up()
    {
        Schema::create('pay_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->foreignId('forma_pagos_id')->constrained('forma_pagos');
            $table->float('valor');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('pay_transactions');
    }
}
