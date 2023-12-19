<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Return_;

class Categoria extends Model
{
    
    protected $fillable = ["nombre"];

    public function productos(){

        return $this->hasMany(Produtos::class);
        
    }

}
