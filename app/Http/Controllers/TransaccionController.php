<?php

namespace App\Http\Controllers;

use App\Concepto;
use Illuminate\Http\Request;
use App\Transaccion;
use Exception;

class TransaccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-transaccion|crear-transaccion|editar-transaccion|borrar-transaccion',['only'=>['index']]);
        $this->middleware('permission:crear-transaccion',['only'=>['create','store']]);
        $this->middleware('permission:editar-transaccion',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-transaccion',['only'=>['destroy']]);
    }

    public function index()
    {

        $transacciones = Transaccion::all();
        return view('transacciones.index',compact('transacciones'));

    }

    public function create()
    {

        return view('transacciones.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required'],
            'caja' => ['required'],
            'inventario' => ['required'],
        ]);

         $transaccion = Transaccion::create([
                'nombre' => $request->get('nombre'),
                'caja' => $request->get('caja'),
                'inventario' => $request->get('inventario'),
            ]);

        return redirect()->route('transacciones.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $transaccion = Transaccion::find($id);
            
        return view('transacciones.editar',compact('transaccion'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
        'caja' => ['required'],
        'inventario' => ['required'],
    ]);

         $transaccion = Transaccion::find($id);  
         $transaccion->nombre = $request->get('nombre');
         $transaccion->caja = $request->get('caja');
         $transaccion->inventario = $request->get('inventario');
        
        $transaccion->save();

        return redirect()->route('transacciones.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $transaccion = Transaccion::find($id);

        try {
            
            $transaccion->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('transacciones.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('transacciones.index')->with('success', 'Registro eliminado correctamente.');
    }

    public function getTipoTransaccion(Request $request){

        if($request->get('concepto')){

            try {
                
                $query = $request->get('concepto');

                $transaccion = Concepto::where('id',$query)->value('transaccion_id');
                
                return response()->json([

                    "transaccion" => $transaccion

                ]);

            } catch (\Throwable $e) {
                
                return response()->json([

                    "error" => $e

                ]);
            }
    }

}

}