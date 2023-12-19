<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecetaHasProducto extends Model
{
    protected $table = "recetas_has_productos";

    protected $fillable = [

        "producto_id",

        "receta_id",

        "cantidad"

    ];

    
}
