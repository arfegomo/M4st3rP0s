<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concepto;
use App\Transaccion;

class ConceptoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-concepto|crear-concepto|editar-concepto|borrar-concepto',['only'=>['index']]);
        $this->middleware('permission:crear-concepto',['only'=>['create','store']]);
        $this->middleware('permission:editar-concepto',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-concepto',['only'=>['destroy']]);
    }

    public function index()
    {

        $conceptos = Concepto::all();
        return view('conceptos.index',compact('conceptos'));

    }

    public function create()
    {

        $conceptos = Concepto::pluck('nombre','id')->all();
        $transacciones = Transaccion::pluck('nombre','id')->all();

        return view('conceptos.crear',compact('conceptos','transacciones'));

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
            'afectacaja' => ['required'],
            'afectainventario' => ['required'],
            'tipo' => ['required'],
            'transaccion_id' => ['required'],
        ]);

         $concepto = Concepto::create([
                'nombre' => $request->get('nombre'),
                'afectacaja' => $request->get('afectacaja'),
                'afectainventario' => $request->get('afectainventario'),
                'tipo' => $request->get('tipo'),
                'transaccion_id' => $request->get('transaccion_id'),
            ]);

        return redirect()->route('conceptos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $concepto = Concepto::find($id);
        $transacciones = Transaccion::pluck('nombre','id')->all();
            
        return view('conceptos.editar',compact('concepto', 'transacciones'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
        'afectacaja' => ['required'],
        'afectainventario' => ['required'],
        'tipo' => ['required'],
    ]);

         $concepto = Concepto::find($id);

         $concepto->nombre = $request->get('nombre');
         $concepto->afectacaja = $request->get('afectacaja');
         $concepto->afectainventario = $request->get('afectainventario');
         $concepto->tipo = $request->get('tipo');
        
        $concepto->save();

        return redirect()->route('conceptos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        try {
            
            $concepto = Concepto::find($id);
            $concepto->delete();
            
            return redirect()->route('conceptos.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('conceptos.index')->with('warning', 'El registro no pudo ser eliminado.');

        }

    }
}
