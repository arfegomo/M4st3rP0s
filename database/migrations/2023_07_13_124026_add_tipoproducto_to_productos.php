<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoproductoToProductos extends Migration
{

    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            
            $table->tinyInteger('tipoproducto');
            
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
}
