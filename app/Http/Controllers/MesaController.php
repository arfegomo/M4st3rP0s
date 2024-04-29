<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Consecutivo;
use App\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function trasladarMesa(Request $request)
    {
        try {
            $trasladarMesa = DB::table('temporaries')
                            ->where('mesa_id', $request->get('origen'))
                            ->update([
                                'mesa_id' => $request->get('destino')
                            ]);

            if($trasladarMesa){
                $mesa = Mesa::find($request->get('origen'));
                $nombreResponsable = $mesa->responsable;
                $mesa->responsable = '';
                $mesa->save();

                $mesa = Mesa::find($request->get('destino'));
                $mesa->responsable = $nombreResponsable;
                $mesa->save();
            }

            return response()->json([
                'data' => 'success'
            ]);

        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json([
                'data' => 'error'
            ]);
            
        }
    }
}
