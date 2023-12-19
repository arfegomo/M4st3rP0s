<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImpuestoToProductos extends Migration
{

    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            
            $table->foreignId('impuesto_id')->constrained('impuestos');
            
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
}
