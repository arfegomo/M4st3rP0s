<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Consecutivo;
use App\DetailTransaction;
use App\Empresa;
use App\FormaPago;
use App\Mesa;
use App\Producto;
use App\Receta;
use App\SocioNegocio;
use App\Temporary;
use App\Transaccion;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class FacturacionController extends Controller
{
    public function __construct()
    {
        
        //$this->middleware('permission:ver-facturacion|crear-facturacion|editar-facturacion|borrar-facturacion',['only'=>['index','indexMesas']]);
        //$this->middleware('permission:crear-facturacion',['only'=>['create']]);
        //$this->middleware('permission:editar-facturacion',['only'=>['edit','update']]);

    }

    public function index(){

            $mesa = 1000;

            $temporaries = Temporary::where("mesa_id", $mesa)->count('mesa_id');

            $conceptos = Concepto::pluck("nombre", "id")->all();

            if($temporaries > 0){
                
                $consecutivo = Temporary::where("mesa_id", $mesa)->distinct('mesa_id')->value('consecutivo_id');

                $temporaries = DB::table('temporaries')
                        ->join("socio_negocios","socio_negocios.documento", "=", "temporaries.documento_id")
                        ->join("conceptos", "conceptos.id", "=", "temporaries.concepto_id")
                        ->join("transacciones", "transacciones.id", "=", "conceptos.transaccion_id")
                        ->distinct("temporaries.consecutivo_id")
                        ->where("temporaries.consecutivo_id", "=", $consecutivo)
                        ->select("temporaries.consecutivo_id","temporaries.concepto_id","socio_negocios.documento","socio_negocios.nombres","socio_negocios.apellidos","conceptos.transaccion_id")
                        ->get();

                return view("facturacion.close", compact("conceptos","consecutivo","temporaries","mesa"));

            }else{

                $consecutivo = Consecutivo::create();

                $consecutivo = $consecutivo->id;

                return view("facturacion.index", compact("conceptos","consecutivo","mesa"));
                
            }
            
    }

    public function indexMesas(Request $request){

            $conceptos = Concepto::pluck("nombre", "id")->all();

            $consecutivo = Consecutivo::create();

            $consecutivo = $consecutivo->id;

            $mesa = $request->get("mesa");

            return view("facturacion.index", compact("conceptos","consecutivo","mesa"));

    }

    public function transaccionesProceso(){

        //DB::enableQueryLog();

        $temporaries = Temporary::with('mesa')->get();/*DB::table('temporaries')
                    ->join("socio_negocios","socio_negocios.documento", "=", "temporaries.documento_id")
                    ->distinct("temporaries.consecutivo_id")
                    ->select("temporaries.consecutivo_id","temporaries.concepto_id","socio_negocios.documento","socio_negocios.nombres","socio_negocios.apellidos")
                    ->get();*/
        
        //dd(DB::getQueryLog());

        return view("facturacion.open", compact("temporaries"));

    }

    public function listItems(Request $request){

        $temporal = DB::table("temporaries")
                                ->join('productos','productos.id', '=', 'temporaries.producto_id')
                                ->where('consecutivo_id', '=', "{$request->get('consecutivo')}")
                                ->select("productos.nombre", "temporaries.preciounitario","temporaries.cantidad","temporaries.descuento","temporaries.id","temporaries.consecutivo_id","temporaries.baseunitario", "temporaries.impuesto")
                                ->get();

            return response()->json([
                  
                "productos" => $temporal
            
            ]);

    }

    public function close(Request $request){

        $conceptos = Concepto::pluck("nombre", "id")->all();

        $consecutivo = $request->get('consecutivo');

        $temporaries = DB::table('temporaries')
                        ->join("socio_negocios","socio_negocios.documento", "=", "temporaries.documento_id")
                        ->join("conceptos", "conceptos.id", "=", "temporaries.concepto_id")
                        ->join("transacciones", "transacciones.id", "=", "conceptos.transaccion_id")
                        ->distinct("temporaries.consecutivo_id")
                        ->where("temporaries.consecutivo_id", "=", $consecutivo)
                        ->select("temporaries.consecutivo_id","temporaries.concepto_id","socio_negocios.documento","socio_negocios.nombres","socio_negocios.apellidos","conceptos.transaccion_id")
                        ->get();

        //dd($conceptos);

        $mesa = $request->get("mesa");

        return view("facturacion.close", compact("conceptos","consecutivo","temporaries","mesa"));

    }

    public function searchSocio(Request $request){

        if($request->get('search')){

            try {
                
                $query = $request->get('search');

                $socios = SocioNegocio::select("nombres", "apellidos", "documento")
                            ->where('nombres', 'LIKE', "%{$query}%")
                            ->orWhere('apellidos', 'LIKE', "%{$query}%")
                            ->get();
                
                            return response()->json($socios);

            } catch (\Throwable $e) {
                
                return response()->json([

                    "error" => $e

                ]);
            }

        }
        
    }

    public function searchProducto(Request $request){

        if($request->get('search')){

            try {
                
                $query = $request->get('search');
                $transaccion = $request->get('transaccion');

                switch($transaccion){

                    case 1:

                        $productos = Producto::select("nombre", "id", "precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            //->where('tipoproducto', $tipoproducto)
                            ->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        

                    case 2:

                        $productos = Producto::select("nombre", "id", "costoactual AS precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 1)
                            //->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        

                    case 3:

                        $productos = Producto::select("nombre", "id", "costoactual AS precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 1)
                            //->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        

                    case 4:

                        $productos = Producto::select("nombre", "id", "costoactual AS precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 1)
                            //->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        

                    case 5:

                        $productos = Producto::select("nombre", "id", "precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            //->where('tipoproducto', $tipoproducto)
                            ->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        

                    case 6:

                        $productos = Producto::select("nombre", "id", "costoactual AS precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 1)
                            //->where('facturable', 1)
                            ->get();

                            return response()->json($productos);

                    break;        
                
                }

            } catch (\Throwable $e) {
                
                return response()->json([
                    
                    "error" =>  $e
                
                ]);

            }

        }
        
    }

    public function searchServiceProduct(Request $request){

        if($request->get('search')){

            try {
                
                $query = $request->get('search');

                $productos = Producto::select("nombre", "id", "precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 2)
                            ->get();
                
                            return response()->json($productos);

            } catch (\Throwable $e) {
                
                return response()->json([
                    
                    "error" =>  $e
                
                ]);

            }

        }
        
    }

    public function searchComponentProduct(Request $request){

        if($request->get('search')){

            try {
                
                $query = $request->get('search');

                $productos = Producto::select("nombre", "id", "precioventa1", "impuesto_id")
                            ->with('impuesto')
                            ->where('nombre', 'LIKE', "%{$query}%")
                            ->where('tipoproducto', 1)
                            ->get();
                
                            return response()->json($productos);

            } catch (\Throwable $e) {
                
                return response()->json([
                    
                    "error" =>  $e
                
                ]);

            }

        }
        
    }

    public function addTemporal(Request $request){

        try {

            $this->validate($request, [

                'impuesto' => ['required'],
                'concepto' => ['required'],
                'documento' => ['required'],
                'cantidad' => ['required'],
                'descuento' => ['required'],
                'impuestoID' => ['required'],
                'precio' => ['required'],
                'productoID' => ['required'],
                'consecutivo' => ['required'],
                'mesa' => ['required']

            ]);

            $temporary = Temporary::create([
                
                'consecutivo_id' => $request->get('consecutivo'),
                'producto_id' => $request->get('productoID'),
                'impuesto_id' => $request->get('impuestoID'),
                'concepto_id' => $request->get('concepto'),
                'documento_id' => $request->get('documento'),
                'cantidad' => $request->get('cantidad'),
                'descuento' => $request->get('descuento'),
                'impuesto' => $request->get('impuesto'),
                'preciounitario' => $request->get('precio'),
                'baseunitario' => ($request->get('precio') / (($request->get('impuesto')/100)+1)),
                'mesa_id' => $request->get('mesa')
            
            ]);

            $temporal = DB::table("temporaries")
                                ->join('productos','productos.id', '=', 'temporaries.producto_id')
                                ->where('consecutivo_id', '=', "{$request->get('consecutivo')}")
                                ->select("productos.nombre", "temporaries.preciounitario","temporaries.cantidad","temporaries.descuento","temporaries.id","temporaries.consecutivo_id","temporaries.baseunitario", "temporaries.impuesto")
                                ->get();

            $idTipoTransaccion = Concepto::where("id", $request->get('concepto'))->value("transaccion_id");

            return response()->json([
                  
                "productos" => $temporal,

                "transaccion" => $idTipoTransaccion,

                "message" => "¡Producto agregado!"
            
            ]);

        
        } catch (\Throwable $th) {
        
            return response()->json([
                    
                "error" =>  $th,

                "transaccion" => "",

                "message" => "Error!"
            
            ]);
        
        }    
        
    }

    public function destroy($id, $consecutivo)
    {
        $facturacion = Temporary::find($id);

        try {
            
            $facturacion->delete();

            $temporal = DB::table("temporaries")
                                ->join('productos','productos.id', '=', 'temporaries.producto_id')
                                ->where('consecutivo_id', '=', "{$consecutivo}")
                                ->select("productos.nombre", "temporaries.preciounitario","temporaries.cantidad","temporaries.descuento","temporaries.id","temporaries.consecutivo_id","temporaries.baseunitario", "temporaries.impuesto")
                                ->get();


            return response()->json([
                    
                "productos" =>  $temporal,

                "message" => "¡Producto eliminado!"
            
            ]);

        } catch ( Exception $ex ) {
            
            return response()->json([
                    
                "error" =>  $ex
            
            ]);
        }
        
    }

    public function store(Request $request){

        //Capturo consecutivo de la tabla temporal
        $consecutivoTemporal = $request->get('consecutivo');

        //Capturo la fecha actual del sistema
        $date = Carbon::now();

        try {
            
            $this->validate($request, [

                'concepto_id' => ['required'],
                'documento_id' => ['required']

            ]);

            //Grabo el encabezado de la factura
            $transactions = Transaction::create([
                
                'concepto_id' => $request->get('concepto_id'),
                'documento_id' => $request->get('documento_id'),
                'user_id' => Auth::id(),
                'fecha' => $date->format("Y-m-d"),
                'hora' => $date->format("H-i-s"),
                'estado' => "N",
                'consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo"),
                'observacion' => $request->get('observacion')               
            
            ]);

            //Retorno los items del documento actual desde la tabla temporal
            $temporaries = Temporary::all()->where("consecutivo_id", "=", $consecutivoTemporal);

            $withreceta = 0;
            $withoutreceta = 0;

            //if the transacction is exits then
            switch($request->get('transaccion_id')){

                case 1://ventas

                    //I update the inventory for each item
                    foreach($temporaries as $temporary){

                        //Validate if the product has recipe
                        if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){

                            $withreceta = $withreceta + 1;

                            //grabo el detalle de la transacción
                            DetailTransaction::create([
                            
                                'transaction_id' => $transactions->id,
                                'producto_id' => $temporary->producto_id,
                                'impuesto_id' => $temporary->impuesto_id,
                                'cantidad' => $temporary->cantidad,
                                'descuento' => $temporary->descuento,
                                'impuesto' => $temporary->impuesto,
                                'preciounitario' => $temporary->preciounitario,
                                'baseunitario' => $temporary->baseunitario,
                                'costoventa' => DB::table('productos')
                                                        ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                        ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                        ->where('recetas.id', $temporary->producto_id)
                                                        ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                        ->value('coste_total'),
                                'costopromedio' => DB::table('productos')
                                                        ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                        ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                        ->where('recetas.id', $temporary->producto_id)
                                                        ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                        ->value('coste_total'),
                            
                            ]);
                            //fin

                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent - $temporary->cantidad);
                            $producto->save();

                            //We search the components what belong to the recipe
                            $dataReceta = Receta::find($temporary->producto_id);

                            $dataReceta->productos;

                            foreach($dataReceta->productos as $receta){

                                //I get the amount current
                                $amountCurrent = Producto::where("id", $receta->id)->value("existenciactual");
                                //I update the inventory
                                $producto = Producto::find($receta->id);
                                $producto->existenciactual = ($amountCurrent - ($receta->pivot->cantidad * $temporary->cantidad));
                                
                                $producto->save();

                            }
                            //fin

                            //I update current coste for finished product
                            $producto = Producto::find($temporary->producto_id);
                            $producto->costoactual = DB::table('productos')
                                                            ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                            ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                            ->where('recetas.id', $temporary->producto_id)
                                                            ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                            ->value('coste_total');
                            $producto->save();

                        }
                        //fin
                        
                        //if the product has not component
                        else{

                            $withoutreceta = $withoutreceta + 1;
                            //grabo el detalle de la transacción
                            DetailTransaction::create([
                                
                                'transaction_id' => $transactions->id,
                                'producto_id' => $temporary->producto_id,
                                'impuesto_id' => $temporary->impuesto_id,
                                'cantidad' => $temporary->cantidad,
                                'descuento' => $temporary->descuento,
                                'impuesto' => $temporary->impuesto,
                                'preciounitario' => $temporary->preciounitario,
                                'baseunitario' => $temporary->baseunitario,
                                'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                            
                            ]);   

                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent - $temporary->cantidad);
                            $producto->costoactual = Producto::where('id', $temporary->producto_id)->value('costoactual');
                            $producto->save();

                        }
                        //fin

                    }
                    //fin

                    //valido la forma de pago si es diferente de múltiples formas de pago
                    if($request->get("pago_id") != 5){

                        FormaPago::create([

                            'pago_id' => $request->get("pago_id"),
                            'transaction_id' => $transactions->id,
                            'valor' => $request->get("valor")
            
                        ]);
                        //de lo contrario si selecciono múltiples formas de pago -> las grabamos
                        }else{

                            foreach($request->get("formas_pago") as $data){

                                FormaPago::create([

                                    'pago_id' => $data["id"],
                                    'transaction_id' => $transactions->id,
                                    'valor' => $data["valor"]
                    
                                ]);

                            }

                    }
                    //fin            

                    //En la transacción hay algún producto que tiene receta ?
                    if($withreceta >= 1){
            
                        //Grabo el encabezado de la entrada del produto terminado
                        $transactions = Transaction::create([
                            
                            'concepto_id' => 98,
                            'documento_id' => $request->get('documento_id'),
                            'user_id' => Auth::id(),
                            'fecha' => $date->format("Y-m-d"),
                            'hora' => $date->format("H-i-s"),
                            'estado' => "N",
                            'consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo"),
                            'observacion' => $request->get('observacion')               
                        
                        ]);       

                        //Grabo los detalles de la entrada del producto terminado
                        foreach($temporaries as $temporary){

                            //Validate if the product has recipe
                            if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){
                        
                                DetailTransaction::create([
                                        
                                    'transaction_id' => $transactions->id,
                                    'producto_id' => $temporary->producto_id,
                                    'impuesto_id' => 4,
                                    'cantidad' => $temporary->cantidad,
                                    'descuento' => 0,
                                    'impuesto' => 0,
                                    'preciounitario' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'baseunitario' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                
                                ]);   

                            }
                            
                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent + $temporary->cantidad);
                            //$producto->costoactual = Producto::where('id', $temporary->producto_id)->value('costoactual');
                            $producto->save();
                        }
                        
                        //Grabo el encabezado de la salida de la materia prima
                        $transactions = Transaction::create([
                            
                            'concepto_id' => 99,
                            'documento_id' => $request->get('documento_id'),
                            'user_id' => Auth::id(),
                            'fecha' => $date->format("Y-m-d"),
                            'hora' => $date->format("H-i-s"),
                            'estado' => "N",
                            'consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo"),
                            'observacion' => $request->get('observacion')               
                        
                        ]); 
                        
                        //Grabo el detalle de la salida de la materia prima por cada producto con receta
                        foreach($temporaries as $temporary){

                            //Validate if the product has recipe
                            if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){

                                //We search the components what belong to the recipe
                                $dataReceta = Receta::find($temporary->producto_id);

                                $dataReceta->productos;

                                //grabo el detalle de la transacción
                                foreach($dataReceta->productos as $receta){

                                        DetailTransaction::create([
                                        
                                            'transaction_id' => $transactions->id,
                                            'producto_id' => $receta->pivot->producto_id,
                                            'impuesto_id' => 4,
                                            'cantidad' => $receta->pivot->cantidad * $temporary->cantidad,
                                            'descuento' => 0,
                                            'impuesto' => 0,
                                            'preciounitario' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'baseunitario' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'costoventa' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'costopromedio' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                        
                                        ]);
                                        //fin
                                }

                            }

                        }

                    }

                    //si se grabó el encabezado actualizo el consecutivo
                    if($transactions){

                        DB::table("transacciones")
                            ->where("id", $request->get('transaccion_id'))
                            ->update(['consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo") + 1]);
                    
                    }
                    //fin

                    $mesa = Mesa::find($request->get('mesa'));  
         
                    $mesa->responsable = $request->get('');
                    
                    $mesa->save();

                break;

                case 2://Compras
                    
                    //I update the inventory for each item
                    foreach($temporaries as $temporary){

                        //grabo el detalle de la transacción
                        DetailTransaction::create([
                        
                            'transaction_id' => $transactions->id,
                            'producto_id' => $temporary->producto_id,
                            'impuesto_id' => $temporary->impuesto_id,
                            'cantidad' => $temporary->cantidad,
                            'descuento' => $temporary->descuento,
                            'impuesto' => $temporary->impuesto,
                            'preciounitario' => $temporary->preciounitario,
                            'baseunitario' => $temporary->baseunitario,
                            'costoventa' => ((($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100))) / $temporary->cantidad),
                            'costopromedio' => ( 
                                round(( ( (Producto::where('id', $temporary->producto_id)->value('existenciactual') * Producto::where('id', $temporary->producto_id)->value('costoactual')) + (($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100)))  ) / (Producto::where('id', $temporary->producto_id)->value('existenciactual') + $temporary->cantidad) ),2)
                            ),                    
                        
                        ]);

                        //I get the amount current
                        $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                        //I update the inventory
                        $producto = Producto::find($temporary->producto_id);
                        $producto->existenciactual = ($amountCurrent + $temporary->cantidad);
                        $producto->costoactual = round(( ( (Producto::where('id', $temporary->producto_id)->value('existenciactual') * Producto::where('id', $temporary->producto_id)->value('costoactual')) + (($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100)))  ) / (Producto::where('id', $temporary->producto_id)->value('existenciactual') + $temporary->cantidad) ),2);
                        $producto->save();

                    }

                    //valido la forma de pago si es diferente de múltiples formas de pago
                    if($request->get("pago_id") != 5){

                        FormaPago::create([

                            'pago_id' => $request->get("pago_id"),
                            'transaction_id' => $transactions->id,
                            'valor' => $request->get("valor")
            
                        ]);
                        //de lo contrario si selecciono múltiples formas de pago -> las grabamos
                        }else{

                            foreach($request->get("formas_pago") as $data){

                                FormaPago::create([

                                    'pago_id' => $data["id"],
                                    'transaction_id' => $transactions->id,
                                    'valor' => $data["valor"]
                    
                                ]);

                            }

                    }
                    //fin            

                break;

                case 3://Salidas
                    
                        //I update the inventory for each item
                        foreach($temporaries as $temporary){

                            //grabo el detalle de la transacción
                            DetailTransaction::create([
                        
                                'transaction_id' => $transactions->id,
                                'producto_id' => $temporary->producto_id,
                                'impuesto_id' => $temporary->impuesto_id,
                                'cantidad' => $temporary->cantidad,
                                'descuento' => $temporary->descuento,
                                'impuesto' => $temporary->impuesto,
                                'preciounitario' => $temporary->preciounitario,
                                'baseunitario' => $temporary->baseunitario,
                                'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),                    
                        
                            ]);

    
                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent - $temporary->cantidad);
                            $producto->save();
    
                        }
    
                break;

                case 4://Entradas
                    
                    //I update the inventory for each item
                    foreach($temporaries as $temporary){

                        //grabo el detalle de la transacción
                        DetailTransaction::create([
                    
                            'transaction_id' => $transactions->id,
                            'producto_id' => $temporary->producto_id,
                            'impuesto_id' => $temporary->impuesto_id,
                            'cantidad' => $temporary->cantidad,
                            'descuento' => $temporary->descuento,
                            'impuesto' => $temporary->impuesto,
                            'preciounitario' => $temporary->preciounitario,
                            'baseunitario' => $temporary->baseunitario,
                            'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                            'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),                    
                    
                        ]);


                        //I get the amount current
                        $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                        //I update the inventory
                        $producto = Producto::find($temporary->producto_id);
                        $producto->existenciactual = ($amountCurrent + $temporary->cantidad);
                        $producto->save();

                    }

                break;

                case 5://Devoluciones ventas

                   //I update the inventory for each item
                   foreach($temporaries as $temporary){

                        //Validate if the product has recipe
                        if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){

                            $withreceta = $withreceta + 1;

                            //grabo el detalle de la transacción
                            DetailTransaction::create([
                            
                                'transaction_id' => $transactions->id,
                                'producto_id' => $temporary->producto_id,
                                'impuesto_id' => $temporary->impuesto_id,
                                'cantidad' => $temporary->cantidad,
                                'descuento' => $temporary->descuento,
                                'impuesto' => $temporary->impuesto,
                                'preciounitario' => $temporary->preciounitario,
                                'baseunitario' => $temporary->baseunitario,
                                'costoventa' => DB::table('productos')
                                                        ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                        ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                        ->where('recetas.id', $temporary->producto_id)
                                                        ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                        ->value('coste_total'),
                                'costopromedio' => DB::table('productos')
                                                        ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                        ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                        ->where('recetas.id', $temporary->producto_id)
                                                        ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                        ->value('coste_total'),
                            
                            ]);
                            //fin

                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent + $temporary->cantidad);
                            $producto->save();

                            //We search the components what belong to the recipe
                            $dataReceta = Receta::find($temporary->producto_id);

                            $dataReceta->productos;

                            foreach($dataReceta->productos as $receta){

                                //I get the amount current
                                $amountCurrent = Producto::where("id", $receta->id)->value("existenciactual");
                                //I update the inventory
                                $producto = Producto::find($receta->id);
                                $producto->existenciactual = ($amountCurrent + ($receta->pivot->cantidad * $temporary->cantidad));
                                
                                $producto->save();

                            }
                            //fin

                            //I update current coste for finished product
                            $producto = Producto::find($temporary->producto_id);
                            $producto->costoactual = DB::table('productos')
                                                            ->join('recetas_has_productos', 'productos.id', '=', 'recetas_has_productos.producto_id')
                                                            ->join('recetas', 'recetas_has_productos.receta_id', '=', 'recetas.id')
                                                            ->where('recetas.id', $temporary->producto_id)
                                                            ->selectRaw('SUM(recetas_has_productos.cantidad * productos.costoactual) AS coste_total')
                                                            ->value('coste_total');
                            $producto->save();

                        }
                        //fin
                        
                        //if the product has not component
                        else{

                                $withoutreceta = $withoutreceta + 1;
                                //grabo el detalle de la transacción
                                    DetailTransaction::create([
                                        
                                        'transaction_id' => $transactions->id,
                                        'producto_id' => $temporary->producto_id,
                                        'impuesto_id' => $temporary->impuesto_id,
                                        'cantidad' => $temporary->cantidad,
                                        'descuento' => $temporary->descuento,
                                        'impuesto' => $temporary->impuesto,
                                        'preciounitario' => $temporary->preciounitario,
                                        'baseunitario' => $temporary->baseunitario,
                                        'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                        'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    
                                    ]);   

                                //I get the amount current
                                $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                                //I update the inventory
                                $producto = Producto::find($temporary->producto_id);
                                $producto->existenciactual = ($amountCurrent + $temporary->cantidad);
                                $producto->costoactual = Producto::where('id', $temporary->producto_id)->value('costoactual');
                                $producto->save();

                        }
                        //fin

                    }
                    //fin

                    //valido la forma de pago si es diferente de múltiples formas de pago
                    if($request->get("pago_id") != 5){

                        FormaPago::create([

                            'pago_id' => $request->get("pago_id"),
                            'transaction_id' => $transactions->id,
                            'valor' => $request->get("valor")
            
                        ]);
                        //de lo contrario si selecciono múltiples formas de pago -> las grabamos
                        }else{

                            foreach($request->get("formas_pago") as $data){

                                FormaPago::create([

                                    'pago_id' => $data["id"],
                                    'transaction_id' => $transactions->id,
                                    'valor' => $data["valor"]
                    
                                ]);

                            }

                    }
                    //fin            

                    //En la transacción hay algún producto que tiene receta ?
                    if($withreceta >= 1){
            
                        //Grabo el encabezado de la salida del produto terminado
                        $transactions = Transaction::create([
                            
                            'concepto_id' => 97,
                            'documento_id' => $request->get('documento_id'),
                            'user_id' => Auth::id(),
                            'fecha' => $date->format("Y-m-d"),
                            'hora' => $date->format("H-i-s"),
                            'estado' => "N",
                            'consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo"),
                            'observacion' => $request->get('observacion')               
                        
                        ]);       

                        //Grabo los detalles de la salida del producto terminado
                        foreach($temporaries as $temporary){

                            //Validate if the product has recipe
                            if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){
                        
                                DetailTransaction::create([
                                        
                                    'transaction_id' => $transactions->id,
                                    'producto_id' => $temporary->producto_id,
                                    'impuesto_id' => 4,
                                    'cantidad' => $temporary->cantidad,
                                    'descuento' => 0,
                                    'impuesto' => 0,
                                    'preciounitario' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'baseunitario' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'costoventa' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                    'costopromedio' => Producto::where('id', $temporary->producto_id)->value('costoactual'),
                                
                                ]);   

                            }
                            
                            //I get the amount current
                            $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                            //I update the inventory
                            $producto = Producto::find($temporary->producto_id);
                            $producto->existenciactual = ($amountCurrent - $temporary->cantidad);
                            //$producto->costoactual = Producto::where('id', $temporary->producto_id)->value('costoactual');
                            $producto->save();
                        }
                        
                        //Grabo el encabezado de la entrada de la materia prima
                        $transactions = Transaction::create([
                            
                            'concepto_id' => 96,
                            'documento_id' => $request->get('documento_id'),
                            'user_id' => Auth::id(),
                            'fecha' => $date->format("Y-m-d"),
                            'hora' => $date->format("H-i-s"),
                            'estado' => "N",
                            'consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo"),
                            'observacion' => $request->get('observacion')               
                        
                        ]); 
                        
                        //Grabo el detalle de la entrada de la materia prima por cada producto con receta
                        foreach($temporaries as $temporary){

                            //Validate if the product has recipe
                            if(DB::table('recetas_has_productos')->where('receta_id', $temporary->producto_id)->exists()){

                                //We search the components what belong to the recipe
                                $dataReceta = Receta::find($temporary->producto_id);

                                $dataReceta->productos;

                                //grabo el detalle de la transacción
                                foreach($dataReceta->productos as $receta){

                                        DetailTransaction::create([
                                        
                                            'transaction_id' => $transactions->id,
                                            'producto_id' => $receta->pivot->producto_id,
                                            'impuesto_id' => 4,
                                            'cantidad' => $receta->pivot->cantidad * $temporary->cantidad,
                                            'descuento' => 0,
                                            'impuesto' => 0,
                                            'preciounitario' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'baseunitario' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'costoventa' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                            'costopromedio' => Producto::where('id', $receta->pivot->producto_id)->value('costoactual'),
                                        
                                        ]);
                                        //fin
                                }

                            }

                        }

                    }

                    //si se grabó el encabezado actualizo el consecutivo
                    if($transactions){

                        DB::table("transacciones")
                            ->where("id", $request->get('transaccion_id'))
                            ->update(['consecutivo' => Transaccion::where("id", $request->get('transaccion_id'))->max("consecutivo") + 1]);
                    
                    }

                break;

                case 6://Devoluciones compras
                    
                    //I update the inventory for each item
                    foreach($temporaries as $temporary){

                        //grabo el detalle de la transacción
                        DetailTransaction::create([
                        
                            'transaction_id' => $transactions->id,
                            'producto_id' => $temporary->producto_id,
                            'impuesto_id' => $temporary->impuesto_id,
                            'cantidad' => $temporary->cantidad,
                            'descuento' => $temporary->descuento,
                            'impuesto' => $temporary->impuesto,
                            'preciounitario' => $temporary->preciounitario,
                            'baseunitario' => $temporary->baseunitario,
                            'costoventa' => ((($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100))) / $temporary->cantidad),
                            'costopromedio' => ( 
                                round(( ( (Producto::where('id', $temporary->producto_id)->value('existenciactual') * Producto::where('id', $temporary->producto_id)->value('costoactual')) + (($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100)))  ) / (Producto::where('id', $temporary->producto_id)->value('existenciactual') + $temporary->cantidad) ),2)
                            ),                    
                        
                        ]);

                        //I get the amount current
                        $amountCurrent = Producto::where("id", $temporary->producto_id)->value("existenciactual");
                        //I update the inventory
                        $producto = Producto::find($temporary->producto_id);
                        $producto->existenciactual = ($amountCurrent - $temporary->cantidad);
                        $producto->costoactual = round(( ( (Producto::where('id', $temporary->producto_id)->value('existenciactual') * Producto::where('id', $temporary->producto_id)->value('costoactual')) + (($temporary->preciounitario*$temporary->cantidad)-(($temporary->preciounitario*$temporary->cantidad)*($temporary->descuento/100)))  ) / (Producto::where('id', $temporary->producto_id)->value('existenciactual') + $temporary->cantidad) ),2);
                        $producto->save();

                    }

                    //valido la forma de pago si es diferente de múltiples formas de pago
                    if($request->get("pago_id") != 5){

                        FormaPago::create([

                            'pago_id' => $request->get("pago_id"),
                            'transaction_id' => $transactions->id,
                            'valor' => $request->get("valor")
            
                        ]);
                        //de lo contrario si selecciono múltiples formas de pago -> las grabamos
                        }else{

                            foreach($request->get("formas_pago") as $data){

                                FormaPago::create([

                                    'pago_id' => $data["id"],
                                    'transaction_id' => $transactions->id,
                                    'valor' => $data["valor"]
                    
                                ]);

                            }

                    }
                    //fin            

                break;

            }

            //eliminamos de la tabla temporal la transacción
            $temporary = Temporary::where("consecutivo_id", $consecutivoTemporal);
            
            $temporary->delete();

            return response()->json([

                "message" => "¡Transacción grabada con éxito!",

            ]);
               
        } catch (\Throwable $th) {
            
            return response()->json([
                    
                "error" =>  $th,

                "message" => "¡Error en la transacción!"
            
            ]);
        }

    }

    public function mesas(){

        $mesas = Mesa::all();

        return view("mesas.index", compact("mesas"));

    }

}
