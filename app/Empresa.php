<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        "nombre", 
        "nit", 
        "digitoverificacion", 
        "direccion", 
        "ciudad_id", 
        "consecutivo", 
        "telefono", 
        "celular", 
        "email"];
}
