<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocioNegocio extends Model
{
    protected $table = "socio_negocios";

    protected $fillable = [
        
        "nombres", 
        "apellidos", 
        "documento", 
        "direccion", 
        "email", 
        "tiposocio", 
        "tipo_documento_id", 
        "ciudad_id" 
    
    ];

    public function tipoDocumento(){
        
        return $this->belongsTo(TipoDocumento::class);
    }

    public function transactions(){

        return $this->hasMany(Transaction::class, "documento", "documento_id");

    }

    public function temporaries(){

        return $this->hasMany(Temporary::class,'documento', 'documento_id');

    }

}
