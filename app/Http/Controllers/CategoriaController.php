<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
Use Exception;

class CategoriaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|borrar-categoria',['only'=>['index']]);
        $this->middleware('permission:crear-categoria',['only'=>['create','store']]);
        $this->middleware('permission:editar-categoria',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-categoria',['only'=>['destroy']]);
    }

    public function index()
    {

        $categorias = Categoria::all();
        return view('categorias.index',compact('categorias'));

    }

    public function create()
    {

        return view('categorias.crear');

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
        ]);

         $categoria = Categoria::create([
                'nombre' => $request->get('nombre'),
            ]);

        return redirect()->route('categorias.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $categoria = Categoria::find($id);
            
        return view('categorias.editar',compact('categoria'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'nombre' => 'required|max:255',
             ]);

         $categoria = Categoria::find($id);  
         $categoria->nombre = $request->get('nombre');
        
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        try {
            
            $categoria->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('categorias.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('categorias.index')->with('success', 'Registro eliminado correctamente.');
    }

}
