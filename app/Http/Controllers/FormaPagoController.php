<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormaPago;
use Exception;

class FormaPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-formapago|crear-formapago|editar-formapago|borrar-formapago',['only'=>['index']]);
        $this->middleware('permission:crear-formapago',['only'=>['create','store']]);
        $this->middleware('permission:editar-formapago',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-formapago',['only'=>['destroy']]);
    }

    public function index()
    {

        $formapagos = formapago::all();
        return view('formapagos.index',compact('formapagos'));

    }

    public function create()
    {

        return view('formapagos.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
        ]);

         $formapago = formapago::create([
                'nombre' => $request->get('nombre'),
            ]);

        return redirect()->route('formapagos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $formapago = formapago::find($id);
            
        return view('formapagos.editar',compact('formapago'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
    ]);

         $formapago = formapago::find($id);  
         $formapago->nombre = $request->get('nombre');
        
        $formapago->save();

        return redirect()->route('formapagos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $formapago = formapago::find($id);

        try {
            
            $formapago->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('formapagos.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('formapagos.index')->with('success', 'Registro eliminado correctamente.');
    }

}
