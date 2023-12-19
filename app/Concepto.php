<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $fillable = ["nombre", "afectacaja", "afectainventario", "tipo", "transaccion_id"];

    public function transaccion(){
        
        return $this->belongsTo(Transaccion::class);
        
    }

    public function transaction(){

        return $this->hasMany(Transaction::class);

    }
}
