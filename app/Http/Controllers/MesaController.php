<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Consecutivo;
use App\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function updateMesa(Request $request)
    {
        $this->validate($request,[
            
            'responsable' => 'required|max:255',
        
        ]);

         $mesa = Mesa::find($request->get('mesa-id'));  
         
         $mesa->responsable = $request->get('responsable');
        
         $mesa->save();

         $conceptos = Concepto::pluck("nombre", "id")->all();

        $consecutivo = Consecutivo::create();

        $consecutivo = $consecutivo->id;

        $mesa = $request->get('mesa-id');

        return view("facturacion.index", compact("conceptos","consecutivo","mesa"));

    }
}
