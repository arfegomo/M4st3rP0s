<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Impuesto;
use Exception;

class ImpuestoController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-impuesto|crear-impuesto|editar-impuesto|borrar-impuesto',['only'=>['index']]);
        $this->middleware('permission:crear-impuesto',['only'=>['create','store']]);
        $this->middleware('permission:editar-impuesto',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-impuesto',['only'=>['destroy']]);
    }

    public function index()
    {

        $impuestos = Impuesto::all();
        return view('impuestos.index',compact('impuestos'));

    }

    public function create()
    {

        return view('impuestos.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
            'tasa' => ['required', 'integer']
        ]);

         $impuesto = Impuesto::create([
                'nombre' => $request->get('nombre'),
                'tasa' => $request->get('tasa'),
            ]);

        return redirect()->route('impuestos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $impuesto = Impuesto::find($id);
            
        return view('impuestos.editar',compact('impuesto'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
        'tasa' => ['required', 'integer']
    ]);

         $impuesto = Impuesto::find($id);  
         $impuesto->nombre = $request->get('nombre');
         $impuesto->tasa = $request->get('tasa');
        
        $impuesto->save();

        return redirect()->route('impuestos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $impuesto = Impuesto::find($id);

        try {
            
            $impuesto->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('impuestos.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('impuestos.index')->with('success', 'Registro eliminado correctamente.');
    }

}
