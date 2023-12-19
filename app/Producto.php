<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    protected $fillable = ["nombre", "categoria_id", "costoinicial", "costoactual", "existenciainicial", "existenciactual", "facturable", "habilita", "stockminimo", "stockmaximo", "precioventa1", "precioventa2", "impuesto_id", "tipoproducto"];

    
    public function categoria(){

        return $this->belongsTo(Categoria::class);
        
    }

    public function impuesto(){

        return $this->belongsTo(Impuesto::class);
    
    }

    public function recetas()
    {
        return $this->belongsToMany('App\Receta','recetas_has_productos')->withPivot('cantidad');;

    }

    public function transactions(){

        return $this->belongsToMany('App\Transaction', 'detail_transactions')
                        ->with('concepto')
                        ->withPivot('cantidad','costoventa','costopromedio','descuento','preciounitario');
        
    }

    public function fiscal(){

        return $this->belongsToMany('App\Transaction', 'detail_transactions')
                        ->with('concepto')
                        ->withPivot('cantidad','costoventa','costopromedio','descuento','preciounitario')                        
                        ->where('transactions.fecha',date('Y-m-d'));
    }

}
