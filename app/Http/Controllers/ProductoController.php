<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Producto;
use App\Impuesto;
use App\Categoria;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function __construct()

    {
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|borrar-producto',['only'=>['index']]);
        $this->middleware('permission:crear-producto',['only'=>['create','store']]);
        $this->middleware('permission:editar-producto',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-producto',['only'=>['destroy']]);
    }

    public function index()
    {

        $productos = Producto::all();
        return view('productos.index',compact('productos'));

    }

    public function create()
    {

        $impuestos = Impuesto::select(DB::raw("CONCAT(nombre,' - ',tasa) AS nombre"),'id')->pluck('nombre','id')->all();
        $categorias = Categoria::pluck('nombre','id')->all();

        return view('productos.crear',compact('impuestos', 'categorias'));

    }

    public function store(Request $request)
    {

         $this->validate($request, [
            
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required'],
            'impuesto_id' => ['required'],
            'facturable' => ['required', 'integer'],
            'habilita' => ['required', 'integer'],
            'tipoproducto' => ['required', 'integer'],

        ]);

         $producto = Producto::create([

                'nombre' => $request->get('nombre'),
                'categoria_id' => $request->get('categoria_id'),
                'impuesto_id' => $request->get('impuesto_id'),
                'facturable' => $request->get('facturable'),
                'habilita' => $request->get('habilita'),
                'stockminimo' => $request->get('stockminimo'),
                'stockmaximo' => $request->get('stockmaximo'),
                'precioventa1' => $request->get('precioventa1'),
                'precioventa2' => $request->get('precioventa2'),
                'tipoproducto' => $request->get('tipoproducto'),

            ]);

        return redirect()->route('productos.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {

        $producto = Producto::find($id);
        
        $impuestos = Impuesto::select(DB::raw("CONCAT(nombre,' - ',tasa) AS nombre"),'id')->pluck('nombre','id')->all();
        $categorias = Categoria::pluck('nombre','id')->all();
            
        return view('productos.editar',compact('producto', 'impuestos', 'categorias'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required'],
            'impuesto_id' => ['required'],
            'facturable' => ['required', 'integer'],
            'habilita' => ['required', 'integer'],
            'tipoproducto' => ['required', 'integer'],
    ]);

         $producto = Producto::find($id);

         $producto->nombre = $request->get('nombre');
         $producto->categoria_id = $request->get('categoria_id');
         $producto->impuesto_id = $request->get('impuesto_id');         
         $producto->facturable = $request->get('facturable');
         $producto->habilita = $request->get('habilita');
         $producto->stockminimo = $request->get('stockminimo');
         $producto->stockmaximo = $request->get('stockmaximo');
         $producto->precioventa1 = $request->get('precioventa1');
         $producto->precioventa2 = $request->get('precioventa2');
         $producto->tipoproducto = $request->get('tipoproducto');
        
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        try {
            
            $producto = producto::find($id);
            $producto->delete();
            
            return redirect()->route('productos.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('productos.index')->with('warning', 'El registro no puedo ser eliminado.');

        }

    }
}
