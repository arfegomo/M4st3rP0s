<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use App\SocioNegocio;

class SocioNegocioController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-socio|crear-socio|editar-socio|borrar-socio',['only'=>['index']]);
        $this->middleware('permission:crear-socio',['only'=>['create','store']]);
        $this->middleware('permission:editar-socio',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-socio',['only'=>['destroy']]);
    }

    public function index()
    {

        $socios = SocioNegocio::paginate(10);

        return view('socios.index',compact('socios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('socios.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:11', 'unique:socio_negocios'],
            'direccion' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:socio_negocios']            
        ]);

         $socio = SocioNegocio::create([
                'nombres' => $request->get('nombres'),
                'apellidos' => $request->get('apellidos'),
                'documento' => $request->get('documento'),
                'direccion' => $request->get('direccion'),
                'email' => $request->get('email')
            ]);

        return redirect()->route('socios.index')->with('success', 'Registro creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $socios = SocioNegocio::find($id);
    
        return view('socios.editar',compact('socios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('socio_negocios')->ignore($id)],            
        ]);

         $socios = SocioNegocio::find($id);  
         $socios->nombres = $request->get('nombres');
         $socios->apellidos = $request->get('apellidos');
         $socios->direccion = $request->get('direccion');
         $socios->email = $request->get('email');

        $socios->save();         
         
        return redirect()->route('socios.index')->with('success', 'Registro modificado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $socios = SocioNegocio::find($id);
        $socios->delete();
        
        return redirect()->route('socios.index')->with('success', 'Registro eliminado correctamente.');
    }
}
