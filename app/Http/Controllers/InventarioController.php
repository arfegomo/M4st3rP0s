<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Producto;
use App\Transaction;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    
    public function index(){

        $inventarios = Producto::all();

        return view('inventarios.index', compact('inventarios'));

    }

    public function kardex($producto){

        $articulo = Producto::where('id', $producto)->first();

        $kardexs = Producto::find($producto);

        $kardexs->transactions;        

        return view('inventarios.kardex', compact('producto','kardexs','articulo'));

    }

}
