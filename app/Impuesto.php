<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    
    protected $fillable = ["nombre","tasa"];
    
    
    public function productos(){

        return $this->hasMany(Productos::class);

    }
}
