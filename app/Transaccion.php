<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaccion extends Model
{
    protected $table = "transacciones";

    protected $fillable = ["nombre","caja", "inventario","consecutivo"];

    public function conceptos(){

        return $this->hasMany('App\Concepto');
        
    }
    
}
