<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = [

        "cantidad_personas",
        "responsable"

    ];
     
}
