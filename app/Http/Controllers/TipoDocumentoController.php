<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocumento;
use Exception;

class TipoDocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-tipodocumento|crear-tipodocumento|editar-tipodocumento|borrar-tipodocumento',['only'=>['index']]);
        $this->middleware('permission:crear-tipodocumento',['only'=>['create','store']]);
        $this->middleware('permission:editar-tipodocumento',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-tipodocumento',['only'=>['destroy']]);
    }

    public function index()
    {

        $tiposDocumentos = TipoDocumento::all();
        return view('tiposdocumentos.index',compact('tiposDocumentos'));

    }

    public function create()
    {

        return view('tiposdocumentos.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
        ]);

         $tipoDocumento = TipoDocumento::create([
                'nombre' => $request->get('nombre'),
            ]);

        return redirect()->route('tiposdocumentos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $tipoDocumento = TipoDocumento::find($id);
            
        return view('tiposdocumentos.editar',compact('tipoDocumento'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
    ]);

         $tipoDocumento = TipoDocumento::find($id);  
         $tipoDocumento->nombre = $request->get('nombre');
        
        $tipoDocumento->save();

        return redirect()->route('tiposdocumentos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $tipoDocumento = TipoDocumento::find($id);

        try {
            
            $tipoDocumento->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('tiposdocumentos.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('tiposdocumentos.index')->with('success', 'Registro eliminado correctamente.');
    }

}
