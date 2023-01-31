<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocioNegocio extends Model
{
    protected $fillable = [
        'nombres', 'apellidos', 'documento', 'direccion', 'email',
    ];
}
