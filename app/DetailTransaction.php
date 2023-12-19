<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $table = "detail_transactions";

    protected $fillable = [

        "transaction_id",
        "producto_id",
        "impuesto_id",
        "cantidad",
        "descuento",
        "preciounitario",
        "impuesto",
        "baseunitario",
        "costoventa",
        "referencia",
        "costopromedio"

    ];
    
}
