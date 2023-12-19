<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use Exception;

class DepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-departamento|crear-departamento|editar-departamento|borrar-departamento',['only'=>['index']]);
        $this->middleware('permission:crear-departamento',['only'=>['create','store']]);
        $this->middleware('permission:editar-departamento',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-departamento',['only'=>['destroy']]);
    }

    public function index()
    {

        $departamentos = Departamento::all();
        return view('departamentos.index',compact('departamentos'));

    }

    public function create()
    {

        return view('departamentos.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
        ]);

         $departamento = Departamento::create([
                'nombre' => $request->get('nombre'),
            ]);

        return redirect()->route('departamentos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $departamento = Departamento::find($id);
            
        return view('departamentos.editar',compact('departamento'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
    ]);

         $departamento = Departamento::find($id);  
         $departamento->nombre = $request->get('nombre');
        
        $departamento->save();

        return redirect()->route('departamentos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $departamento = Departamento::find($id);

        try {
            
            $departamento->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('departamentos.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('departamentos.index')->with('success', 'Registro eliminado correctamente.');
    }

}
