<?php

namespace App\Http\Controllers;

use App\Receta;
use App\RecetaHasProducto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{

    public function index(){

        $recetas = Receta::all();

        return view("recetas.index", compact("recetas"));

    }

    public function create()
    {

        return view('recetas.crear');

    }

    public function store(Request $request){

        try {
            
            $this->validate($request, [

                'receta' => ['required'],
                'producto' => ['required'],
                'cantidad' => ['required'],

            ]);

            $receta = RecetaHasProducto::create([
                
                'receta_id' => $request->get('receta'),
                'producto_id' => $request->get('producto'),
                'cantidad' => $request->get('cantidad'),
            
            ]);

            $id = $request->get('receta');

            /*$dataReceta = Producto::with(['recetas' =>  function($query) use($id) {
                $query->whereProductoId($id);
            }])->get();*/

            $dataReceta = Receta::find($request->get('receta'));
            $dataReceta->productos;


            return response()->json([

                "receta" => $dataReceta,

                "message" => "Componente agregado!"

            ]);

        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([

                "message" => "¡Error!"
            
            ]);
        }
    }

    public function searchReceta(Request $request){

        if($request->get('search')){

            try {
                
                $query = $request->get('search');

                $recetas = Receta::select("nombre", "id")
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->get();
                
                            return response()->json($recetas);

            } catch (\Throwable $e) {
                
                return response()->json([
                    
                    "error" =>  $e
                
                ]);

            }

        }
        
    }

    public function destroyReceta($receta, $producto)
    {
    
        try {
            
            DB::table('recetas_has_productos')->where('receta_id', $receta)->where('producto_id', $producto)->delete();

            $dataReceta = Receta::find($receta);
            $dataReceta->productos;

            return response()->json([

                "receta" => $dataReceta,

                "message" => "¡Componente eliminado!"

            ]);

        } catch ( Exception $ex ) {
            
            return response()->json([
                
                "message" => $ex

            ]);
        }
        
        
    }

    public function showReceta(Request $request){

        try {
            
            $dataReceta = Receta::find($request->get("receta"));

            $dataReceta->productos;

            return response()->json([

                "receta" => $dataReceta,

            ]);

        } catch (Exception $ex) {

            return response()->json([

                "receta" => $ex,

            ]);

        }

    }

    public function destroy(Receta $receta){

        try {
            
            $receta->delete();

            return redirect()->route("recetas.index")->with("success","Registro eliminado correctamente.");
            
        } catch (\Throwable $th) {
            
            //throw $th;

            return redirect()->route('recetas.index')->with('warning', 'El registro no puedo ser eliminado.');
        }

    }

    public function createProduct(){
        
        return view('recetas.receta');

    }

    public function addProduct(Request $request){

        try {
            
            $this->validate($request, [

                'producto' => ['required'],
                'producto_id' => ['required'],

            ]);

            $receta = Receta::create([
                
                'id' => $request->get('producto_id'),
                'nombre' => $request->get('producto'),
            
            ]);

            return redirect()->route('recetas.index')->with('success', 'Registro creado correctamente.');

        } catch (\Throwable $th) {
            
            return $th;
        }

    }

}
