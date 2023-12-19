<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Departamento;

class CiudadController extends Controller
{
    public function __construct()
    
    {
        $this->middleware('permission:ver-ciudad|crear-ciudad|editar-ciudad|borrar-ciudad',['only'=>['index']]);
        $this->middleware('permission:crear-ciudad',['only'=>['create','store']]);
        $this->middleware('permission:editar-ciudad',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-ciudad',['only'=>['destroy']]);
    }

    public function index()
    {

        $ciudades = Ciudad::all();
        return view('ciudades.index',compact('ciudades'));

    }

    public function create()
    {

        $departamentos = Departamento::pluck('nombre','id')->all();
        return view('ciudades.crear',compact('departamentos'));

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
            'departamentos' => ['required']
        ]);

         $ciudad = Ciudad::create([
                'nombre' => $request->get('nombre'),
                'departamento_id' => $request->get('departamentos'),
            ]);

        return redirect()->route('ciudades.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $ciudad = Ciudad::find($id);
        $departamentos = Departamento::pluck('nombre','id')->all();
            
        return view('ciudades.editar',compact('ciudad', 'departamentos'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
        'departamento_id' => ['required']
    ]);

         $ciudad = Ciudad::find($id);

         $ciudad->nombre = $request->get('nombre');
         $ciudad->departamento_id = $request->get('departamento_id');
        
        $ciudad->save();

        return redirect()->route('ciudades.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        try {
            
            $ciudad = Ciudad::find($id);
            $ciudad->delete();
            
            return redirect()->route('ciudades.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('ciudades.index')->with('warning', 'El registro no puedo ser eliminado.');

        }

    }
    
}
