<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empresa;
use App\Ciudad;
use Exception;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-empresa|crear-empresa|editar-empresa|borrar-empresa',['only'=>['index']]);
        $this->middleware('permission:crear-empresa',['only'=>['create','store']]);
        $this->middleware('permission:editar-empresa',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-empresa',['only'=>['destroy']]);
    }

    public function index()
    {

        $empresas = Empresa::all();
        return view('empresas.index',compact('empresas'));

    }

    public function create()
    {

        $ciudades = Ciudad::pluck('nombre', 'id')->all();
        
        return view('empresas.crear', compact('ciudades'));

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            
            'nombre' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'integer'],
            'digitoverificacion' => ['required', 'integer'],
            'direccion' => ['required', 'string', 'max:200'],
            'ciudad_id' => ['required'],
            'consecutivo' => ['required', 'integer'],
            'telefono' => ['required', 'integer'],
            'celular' => ['required', 'string', 'max:11'],
            'email' => ['required', 'email', 'max:255'],

        ]);

         $empresa = empresa::create([
                
                'nombre' => $request->get('nombre'),
                'nit' => $request->get('nit'),
                'digitoverificacion' => $request->get('digitoverificacion'),
                'direccion' => $request->get('direccion'),
                'ciudad_id' => $request->get('ciudad_id'),
                'consecutivo' => $request->get('consecutivo'),
                'telefono' => $request->get('telefono'),
                'celular' => $request->get('celular'),
                'email' => $request->get('email'),

            ]);

        return redirect()->route('empresas.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $empresa = empresa::find($id);

        $ciudades = Ciudad::pluck('nombre', 'id')->all();
            
        return view('empresas.editar',compact('empresa','ciudades'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        
            'nombre' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'integer'],
            'digitoverificacion' => ['required', 'integer'],
            'direccion' => ['required', 'string', 'max:200'],
            'ciudad_id' => ['required'],
            'consecutivo' => ['required', 'integer'],
            'telefono' => ['required', 'integer'],
            'celular' => ['required', 'string', 'max:11'],
            'email' => ['required', 'email', 'max:255'],

    ]);

         $empresa = empresa::find($id);  
         
         $empresa->nombre = $request->get('nombre');
         $empresa->nit = $request->get('nit');
         $empresa->digitoverificacion = $request->get('digitoverificacion');
         $empresa->direccion = $request->get('direccion');
         $empresa->ciudad_id = $request->get('ciudad_id');
         $empresa->consecutivo = $request->get('consecutivo');
         $empresa->telefono = $request->get('telefono');
         $empresa->celular = $request->get('celular');
         $empresa->email = $request->get('email');
        
        $empresa->save();

        return redirect()->route('empresas.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        $empresa = empresa::find($id);

        try {
            
            $empresa->delete();

        } catch ( Exception $ex ) {
            
            return redirect()->route('empresas.index')->with('warning', 'El Registro no fue eliminado.');    
        }
        
        return redirect()->route('empresas.index')->with('success', 'Registro eliminado correctamente.');
    }
}
