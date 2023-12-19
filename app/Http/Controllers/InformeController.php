<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index(){

       return view('informes.index');

    }

    public function fiscal(Request $request){

        try {
            
            $ventas = DB::table('productos')
                        ->join('detail_transactions','productos.id','=','detail_transactions.producto_id')
                        ->join('transactions','detail_transactions.transaction_id','=','transactions.id')
                        ->join('conceptos','transactions.concepto_id','=','conceptos.id')
                        //->where('transactions.created_at', $request->get('fecha'))
                        ->whereBetween('transactions.created_at', [$request->get('fechastart'), $request->get('fechaend')])
                        ->where('conceptos.transaccion_id',1)
                        ->select('productos.nombre',DB::raw('SUM(detail_transactions.cantidad) AS cantidad'),DB::raw('SUM((detail_transactions.preciounitario * detail_transactions.cantidad) - ((detail_transactions.preciounitario * detail_transactions.cantidad) * (detail_transactions.descuento/100))) AS total'))
                        ->groupBy('productos.id')
                        ->get();

            $formasPagos = DB::table('forma_pagos')
                        ->join('transactions','forma_pagos.transaction_id','=','transactions.id')
                        ->join('conceptos','transactions.concepto_id','=','conceptos.id')
                        ->whereBetween('transactions.created_at', [$request->get('fechastart'), $request->get('fechaend')])
                        ->where('conceptos.transaccion_id',1)
                        ->selectRaw('(CASE WHEN forma_pagos.pago_id = 1 
                            THEN "Efectivo" WHEN forma_pagos.pago_id = 2 
                            THEN "Tarjeta D/C" WHEN forma_pagos.pago_id = 4 
                            THEN "Nequi" WHEN forma_pagos.pago_id = 6 
                            THEN "Crédito" ELSE "Otro" END) AS forma_pago, 
                            SUM(forma_pagos.valor) AS valor')
                        ->groupBy('forma_pagos.pago_id')
                        ->get();

            $compras = DB::table('productos')
                        ->join('detail_transactions','productos.id','=','detail_transactions.producto_id')
                        ->join('transactions','detail_transactions.transaction_id','=','transactions.id')
                        ->join('conceptos','transactions.concepto_id','=','conceptos.id')
                        //->where('transactions.created_at', $request->get('fecha'))
                        ->whereBetween('transactions.created_at', [$request->get('fechastart'), $request->get('fechaend')])
                        ->where('conceptos.transaccion_id',2)
                        ->select('productos.nombre',DB::raw('SUM(detail_transactions.cantidad) AS cantidad'),DB::raw('SUM((detail_transactions.preciounitario * detail_transactions.cantidad) - ((detail_transactions.preciounitario * detail_transactions.cantidad) * (detail_transactions.descuento/100))) AS total'))
                        ->groupBy('productos.id')
                        ->get();

            $devolucionesVentas = DB::table('productos')
                        ->join('detail_transactions','productos.id','=','detail_transactions.producto_id')
                        ->join('transactions','detail_transactions.transaction_id','=','transactions.id')
                        ->join('conceptos','transactions.concepto_id','=','conceptos.id')
                        ->whereBetween('transactions.created_at', [$request->get('fechastart'), $request->get('fechaend')])
                        //->where('transactions.created_at', $request->get('fecha'))
                        ->where('conceptos.transaccion_id',5)
                        ->select('productos.nombre',DB::raw('SUM(detail_transactions.cantidad) AS cantidad'),DB::raw('SUM((detail_transactions.preciounitario * detail_transactions.cantidad) - ((detail_transactions.preciounitario * detail_transactions.cantidad) * (detail_transactions.descuento/100))) AS total'))
                        ->groupBy('productos.id')
                        ->get();

                        return response()->json([

                            "ventas" => $ventas,
                            "compras" => $compras,
                            "devolucionesVentas" => $devolucionesVentas,
                            "forma_pagos" => $formasPagos

                        ]);


        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([

                "error" => $th,
    
            ]);
        }
        
        
    }

    public function load(){

        return view('informes.fiscal');

    }
}
