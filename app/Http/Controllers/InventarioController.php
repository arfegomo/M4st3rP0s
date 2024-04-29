<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Producto;
use App\Transaction;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    
    public function index(){

        $productos = Producto::where('tipoproducto',1)->get();

        foreach ($productos as $producto) {
            
            $transacciones = Producto::with('transactions')
            ->where('id',$producto->id)
            ->orderBy('created_at', 'ASC')
            ->get();   

            //$transacciones = collect($transacciones)->where('producto_id',$producto->id)->toArray();

            $saldo = 0;

            foreach($transacciones as $kardex){
                foreach($kardex['transactions'] as $item){
                        switch($item["concepto"]["transaccion_id"]){
                            case(1):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(2):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(3):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(4):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(5):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(6):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            default;                    
                        }
                    $producto = Producto::find($item["pivot"]["producto_id"]);
                    $producto->existenciactual = $saldo;
                    $producto->save();
                }
                
            }

        }

        $inventarios = Producto::all();

        return view('inventarios.index', compact('inventarios'));

    }

    public function kardex($producto){

            $transacciones = Producto::with('transactions')
                ->where('id',$producto)
                ->orderBy('created_at', 'ASC')
                ->get();   

            $transacciones = collect($transacciones)->toArray();

            $saldo = 0;

            foreach($transacciones as $kardex){
                foreach($kardex["transactions"] as $item){
                    switch($item["concepto"]["transaccion_id"]){
                        case(1):
                            $saldo = $saldo - $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        case(2):
                            $saldo = $saldo + $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        case(3):
                            $saldo = $saldo - $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        case(4):
                            $saldo = $saldo + $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        case(5):
                            $saldo = $saldo + $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        case(6):
                            $saldo = $saldo - $item["pivot"]["cantidad"];
                            //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                        break;
                        default;                    
                    }
                }
            }

            $kardexs = Producto::find($producto);
            $kardexs->existenciactual = $saldo;
            $kardexs->save();

            $kardexs->transactions;

            $articulo = Producto::where('id', $producto)->first();

            return view('inventarios.kardex', compact('producto','kardexs','articulo'));

    }

    public function updateInventario(){

        $productos = Producto::where('tipoproducto',1)->get();

        foreach ($productos as $producto) {
            
            $transacciones = Producto::with('transactions')
            ->where('id',$producto->i)
            ->orderBy('created_at', 'ASC')
            ->get();   

            //$transacciones = collect($transacciones)->where('producto_id',$producto->id)->toArray();

            $saldo = 0;

            foreach($transacciones as $kardex){
                foreach($kardex['transactions'] as $item){
                        switch($item["concepto"]["transaccion_id"]){
                            case(1):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(2):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(3):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(4):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(5):
                                $saldo = $saldo + $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            case(6):
                                $saldo = $saldo - $item["pivot"]["cantidad"];
                                //echo "Fecha:". $item["pivot"]["created_at"]. "Prodcuto: ".$item["pivot"]["producto_id"] . "Mov.->". $item["pivot"]["cantidad"]. "Saldo:". $saldo . "<br>";
                            break;
                            default;                    
                        }
                    $producto = Producto::find($item["pivot"]["producto_id"]);
                    $producto->existenciactual = $saldo;
                    $producto->save();
                }
                
            }

        }

        return response()->json("Success");
    }

}
