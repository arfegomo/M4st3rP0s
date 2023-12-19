<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = "recetas";

    protected $fillable = ["id","nombre"];

    public $incrementing = false;

    public function productos()
    {
        return $this->belongsToMany('App\Producto','recetas_has_productos')->withPivot('cantidad');
    }

}
