<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $table = "transactions";

    protected $fillable = [
        
        "concepto_id", 
        "documento_id", 
        "user_id", 
        "fecha", 
        "hora", 
        "estado", 
        "consecutivo", 
        "observacion"
    
    ];

    public function concepto(){

        return $this->belongsTo(Concepto::class);

    }

    public function socio(){

        return $this->belongsTo(SocioNegocio::class, "documento_id", "documento");

    }

    public function user(){

        return $this->belongsTo(User::class);

    }

    public function productos(){

        return $this->belongsToMany('App\Producto', 'detail_transactions');
        
    }
}
