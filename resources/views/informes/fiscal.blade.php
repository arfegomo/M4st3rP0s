@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <!--<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('assets/css/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <section class="section">
        
        <section class="section">
        
            <div class="section-header">

                <div class="row">

                    <div class="col-lg-12">
                            
                        <h1 class="page__heading">Informe fiscal</h1>
                        
                        <input id="datepickerstart" width="276" />
                        <input id="datepickerend" width="276" /> 
                            
                    </div> 

                </div>

            </div>

            <div class="section-body">
 
                <div class="row">
 
                    <div class="col-lg-12">
 
                        <div class="card">
 
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-6">

                                        <ul class="list-group">
                                            
                                            <li class="list-group-item" aria-current="true">Informe Fiscal [Ventas]</li>
                                            
                                            <li class="list-group-item">
                                                
                                                <table id="empresas" class="table table-bordered shadow-lg mt-4" style="width:100%">
                                                    <thead class="bg bg-dark">            
                                                        <tr>
                                                            <th style='color:#fff;'>Producto</th>
                                                            <th style='color:#fff;'>Cantidad</th>
                                                            <th style='color:#fff;'>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyVentas">
                                        
                                                    </tbody>
                                                </table>
                                            </li>
                                            
                                        </ul>     

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <ul class="list-group">
                                            
                                            <li class="list-group-item" aria-current="true">Informe Fiscal [Devoluciones Ventas]</li>
                                            
                                            <li class="list-group-item">
                                                
                                                <table id="empresas" class="table table-bordered shadow-lg mt-4" style="width:100%">
                                                    <thead class="bg bg-dark">            
                                                        <tr>
                                                            <th style='color:#fff;'>Producto</th>
                                                            <th style='color:#fff;'>Cantidad</th>
                                                            <th style='color:#fff;'>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyDevolucionesVentas">
                                        
                                                    </tbody>
                                                </table>
                                            </li>
                                            
                                        </ul>     

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <ul class="list-group">
                                            
                                            <li class="list-group-item" aria-current="true">Informe Fiscal [Compras]</li>
                                            
                                            <li class="list-group-item">
                                                
                                                <table id="empresas" class="table table-bordered shadow-lg mt-4" style="width:100%">
                                                    <thead class="bg bg-dark">            
                                                        <tr>
                                                            <th style='color:#fff;'>Producto</th>
                                                            <th style='color:#fff;'>Cantidad</th>
                                                            <th style='color:#fff;'>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyCompras">
                                        
                                                    </tbody>
                                                </table>
                                            </li>
                                            
                                        </ul>     

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <ul class="list-group">
                                            
                                            <li class="list-group-item" aria-current="true">Informe Fiscal [Resumen]</li>
                                            
                                            <li class="list-group-item">
                                                
                                                <table id="empresas" class="table table-bordered shadow-lg mt-4" style="width:100%">
                                                    <thead class="bg bg-dark">            
                                                        <tr>
                                                            <th style='color:#fff;'>Tipo de transacción</th>
                                                            <th style='color:#fff;'>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyResumen">
                                        
                                                    </tbody>
                                                </table>
                                            </li>
                                            
                                        </ul>     

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <ul class="list-group">
                                            
                                            <li class="list-group-item" aria-current="true">[Resumen Ventas - Formas de Pago]</li>
                                            
                                            <li class="list-group-item">
                                                
                                                <table id="empresas" class="table table-bordered shadow-lg mt-4" style="width:100%">
                                                    <thead class="bg bg-dark">            
                                                        <tr>
                                                            <th style='color:#fff;'>Formas de pago [Ventas]</th>
                                                            <th style='color:#fff;'>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyFormaPagos">
                                        
                                                    </tbody>
                                                </table>
                                            </li>
                                            
                                        </ul>     

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        
        </section>
    @endsection

    @section('js')
        
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!--<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>-->
        <script src="{{ asset('assets/js/jquery.datetimepicker.full.min.js') }}"></script>

        <script>
            $('#datepickerstart').datetimepicker({

                format:'Y-m-d H:i',
                
                onSelectTime:function(){

                    fechastart = $('#datepickerstart').val();
                    fechaend = $('#datepickerend').val();

                    srcFiscal = "{{ route('informe.fiscal') }}";

                    $.ajax({            
                        url: srcFiscal,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            fechastart:fechastart, fechaend:fechaend 
                        },

                        success:function(data){

                            //console.log(data.error);

                            var valorVentas = '';

                            var valorCompras = '';

                            var valorDevolucionesVentas = '';

                            var resumen = '';

                            var totalVentas = 0;

                            var totalDevolucionesVentas = 0;

                            var totalCompras = 0;

                            data.ventas.forEach(element => {

                                totalVentas = totalVentas + element.total;

                                valorVentas += `<tr>
                                            
                                            <td>${element.nombre}</td>
                                            <td>${element.cantidad}</td>
                                            <td>${element.total}</td>
                                            
                                        </tr>`;

                        });
                                valorVentas += `<tr>
                                            
                                            <td>TOTAL</td>
                                            <td></td>
                                            <td>${totalVentas}</td>
                                            
                                        </tr>`;

                        $("#tbodyVentas").html(valorVentas);

                        data.compras.forEach(element => {

                            totalCompras = totalCompras + element.total;

                            valorCompras += `<tr>
                                        
                                        <td>${element.nombre}</td>
                                        <td>${element.cantidad}</td>
                                        <td>${element.total}</td>
                                        
                                    </tr>`;

                            });

                            valorCompras += `<tr>
                                        
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td>${totalCompras}</td>
                                        
                                    </tr>`;

                            $("#tbodyCompras").html(valorCompras);

                            data.devolucionesVentas.forEach(element => {

                            totalDevolucionesVentas = totalDevolucionesVentas + element.total;

                            valorDevolucionesVentas += `<tr>
                                        
                                        <td>${element.nombre}</td>
                                        <td>${element.cantidad}</td>
                                        <td>${element.total}</td>
                                        
                                    </tr>`;

                            });

                            valorDevolucionesVentas += `<tr>
                                        
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td>${totalDevolucionesVentas}</td>
                                        
                                    </tr>`;


                            $("#tbodyDevolucionesVentas").html(valorDevolucionesVentas);

                            resumen += `<tr>
                                        
                                        <td>Ventas</td>
                                        <td>${totalVentas}</td>
                                        
                                    </tr>`;

                            resumen += `<tr>
                                
                                        <td>Devoluciones Ventas</td>
                                        <td>${totalDevolucionesVentas}</td>
                                        
                                    </tr>`;

                            resumen += `<tr>
                                
                                        <td>Compras</td>
                                        <td>${totalCompras}</td>
                                        
                                    </tr>`;

                            $("#tbodyResumen").html(resumen);
                        }

                    });

                }
            });

            $('#datepickerend').datetimepicker({

                format:'Y-m-d H:i',

                onSelectTime:function(){

                fechastart = $('#datepickerstart').val();
                fechaend = $('#datepickerend').val();

                srcFiscal = "{{ route('informe.fiscal') }}";

                $.ajax({            
                    url: srcFiscal,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        fechastart:fechastart, fechaend:fechaend 
                    },

                    success:function(data){

                        //console.log(data.ventas);

                        var valorVentas = '';

                        var FormaPagos = '';

                        var valorCompras = '';

                        var valorDevolucionesVentas = '';

                        var resumen = '';

                        var totalVentas = 0;

                        var totalDevolucionesVentas = 0;

                        var totalCompras = 0;

                    data.ventas.forEach(element => {

                        totalVentas = totalVentas + element.total;

                        valorVentas += `<tr>
                                    
                                    <td>${element.nombre}</td>
                                    <td>${element.cantidad}</td>
                                    <td>${element.total}</td>
                                    
                                </tr>`;

                    });
                    
                    valorVentas += `<tr>
                                        
                            <td>TOTAL</td>
                            <td></td>
                            <td>${totalVentas}</td>
                            
                        </tr>`;

                    $("#tbodyVentas").html(valorVentas);

                    data.compras.forEach(element => {

                        totalCompras = totalCompras + element.total;

                        valorCompras += `<tr>
                                    
                                    <td>${element.nombre}</td>
                                    <td>${element.cantidad}</td>
                                    <td>${element.total}</td>
                                    
                                </tr>`;

                    });

                    valorCompras += `<tr>
                                
                                <td>TOTAL</td>
                                <td></td>
                                <td>${totalCompras}</td>
                                
                            </tr>`;

                    $("#tbodyCompras").html(valorCompras);

                    data.devolucionesVentas.forEach(element => {

                        totalDevolucionesVentas = totalDevolucionesVentas + element.total;

                        valorDevolucionesVentas += `<tr>
                                    
                                    <td>${element.nombre}</td>
                                    <td>${element.cantidad}</td>
                                    <td>${element.total}</td>
                                    
                                </tr>`;

                    });

                    valorDevolucionesVentas += `<tr>
                            
                            <td>TOTAL</td>
                            <td></td>
                            <td>${totalDevolucionesVentas}</td>
                            
                        </tr>`;
                
                    $("#tbodyDevolucionesVentas").html(valorDevolucionesVentas);

                            resumen += `<tr>
                                        
                                        <td>Ventas</td>
                                        <td>${totalVentas}</td>
                                        
                                    </tr>`;

                            resumen += `<tr>
                                
                                        <td>Devoluciones Ventas</td>
                                        <td>${totalDevolucionesVentas}</td>
                                        
                                    </tr>`;

                            resumen += `<tr>
                                
                                        <td>Compras</td>
                                        <td>${totalCompras}</td>
                                        
                                    </tr>`;

                            $("#tbodyResumen").html(resumen);

                    var totalFormasPago = 0;

                    data.forma_pagos.forEach(element => {

                        totalFormasPago = totalFormasPago + element.valor;

                        FormaPagos += `<tr>
                                        
                                        <td>${element.forma_pago}</td>
                                        <td>${element.valor}</td>
                                        
                                    </tr>`;

                    });

                    FormaPagos += `<tr>
                                        
                                        <td>TOTAL</td>
                                        <td>${totalFormasPago}</td>
                                        
                                    </tr>`;

                    $("#tbodyFormaPagos").html(FormaPagos);

                    }

                });

                }
            });
        </script>        
    

    @endsection








