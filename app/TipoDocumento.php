<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = "tipo_documentos";

    protected $fillable = ["nombre"];

    public function socios(){
        
        return $this->hasMany(Socio::class);
        
    }

}
