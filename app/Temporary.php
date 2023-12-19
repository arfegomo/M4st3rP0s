<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    protected $table = "temporaries";

    protected $fillable = [
        
        "consecutivo_id",
        "producto_id",
        "impuesto_id",
        "concepto_id",
        "documento_id",
        "cantidad",
        "descuento",
        "preciounitario",
        "impuesto",
        "baseunitario",
        "mesa_id"

    ];

    public function socio(){

        return $this->belongsTo(Temporary::class, "documento_id", "documento");

    }

    public function mesa(){

        return $this->belongsTo(Mesa::class);

    }

}
