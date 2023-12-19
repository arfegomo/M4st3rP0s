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
use App\TipoDocumento;
use App\Ciudad;
use Exception;

class SocioNegocioController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-socionegocio|crear-socionegocio|editar-socionegocio|borrar-socionegocio',['only'=>['index']]);
        $this->middleware('permission:crear-socionegocio',['only'=>['create','store']]);
        $this->middleware('permission:editar-socionegocio',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-socionegocio',['only'=>['destroy']]);
    }

    public function index()
    {

        $socios = SocioNegocio::paginate(10);

        return view('socios.index',compact('socios'));
    }

    public function create()
    {
        $tiposDocumentos = TipoDocumento::pluck("nombre","id")->all();
        $ciudades = Ciudad::pluck("nombre","id")->all();

        return view('socios.crear',compact('tiposDocumentos','ciudades'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:11', 'unique:socio_negocios'],
            'direccion' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:socio_negocios'],
            'ciudad' => ['required'],
            'tipodocumento' => ['required'],
            'tiposocio' => ['required'],          
        ]);

         $socio = SocioNegocio::create([
                'nombres' => $request->get('nombres'),
                'apellidos' => $request->get('apellidos'),
                'documento' => $request->get('documento'),
                'direccion' => $request->get('direccion'),
                'email' => $request->get('email'),
                'ciudad_id' => $request->get('ciudad'),
                'tipo_documento_id' => $request->get('tipodocumento'),
                'tiposocio' => $request->get('tiposocio'),
            ]);

        return redirect()->route('socios.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {
        $socio = SocioNegocio::find($id);
        $tiposDocumentos = TipoDocumento::pluck('nombre','id')->all();
        $ciudades = Ciudad::pluck('nombre','id')->all();
    
        return view('socios.editar',compact('socio','tiposDocumentos','ciudades'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('socio_negocios')->ignore($id)],
            'ciudad_id' => ['required'],
            'tipo_documento_id' => ['required'],
            'tiposocio' => ['required']
        ]);

         $socios = SocioNegocio::find($id);  
         $socios->nombres = $request->get('nombres');
         $socios->apellidos = $request->get('apellidos');
         $socios->direccion = $request->get('direccion');
         $socios->email = $request->get('email');
         $socios->ciudad_id = $request->get('ciudad_id');
         $socios->tipo_documento_id = $request->get('tipo_documento_id');
         $socios->tiposocio = $request->get('tiposocio');

         $socios->save();         
         
        return redirect()->route('socios.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        try {
            
            $socios = SocioNegocio::find($id);
            $socios->delete();
        
            return redirect()->route('socios.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('socios.index')->with('success', 'El registro no pudo ser eliminado.');

        }

    }
}
