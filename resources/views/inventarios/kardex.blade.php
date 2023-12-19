@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
@endsection

@section('content')

    <section class="section">
        
        <section class="section">
        
            <div class="section-header">

                <div class="row">

                    <div class="col-lg-12">
                            
                        <h1 class="page__heading">Kardex</h1> | {{ $articulo->nombre }} |
                        <h1 class="page__heading">Existencia actual</h1> | {{ $articulo->existenciactual }} |
                        <h1 class="page__heading">Costo actual</h1> | {{ $articulo->costoactual }} |
                        <h1 class="page__heading">Existencia inicial</h1> | {{ $articulo->existenciainicial }} |
                            
                    </div> 

                </div>

            </div>

            <div class="section-body">
 
                <div class="row">
 
                    <div class="col-lg-12">
 
                        <div class="card">
 
                            <div class="card-body">

                                @if ($errors->any())
    
                                <div class="alert alert-dark alert-dimissible fade show" role="alert">

                                    <span>
                                        @foreach ($errors->all() as $error)
                                            <li class="badge badge-danger">{{ $error }}</li>
                                        @endforeach

                                        <button type="button" class="close" data-dismiss="alert" arial-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </span>

                                </div>

                                @endif

                        @if(session()->has('message'))

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <button type="button" class="close" data-dismiss="alert"></button>
                                {{ session()->get('message') }}
                            </div>

                        @endif

            <table id="kardex" class="table table-bordered shadow-lg mt-4" style="width:100%">
                <thead class="bg bg-dark">            
                    <tr>
                        
                        <th style='color:#fff;'>Fecha</th>
                        <th style='color:#fff;'>Concepto</th>
                        <th style='color:#fff;'>Consecutivo</th>
                        <th style='color:#fff;'>Transaccion</th>
                        <th style='color:#fff;'>Entradas</th>
                        <th style='color:#fff;'>Salidas</th>
                        <th style='color:#fff;'>Costo de venta</th>
                        <th style='color:#fff;'>Costo promedio</th>
                        <th style='color:#fff;'>Saldo</th>
                        
                    </tr>
                </thead>

                    <tr>
                        @php($saldo = 0)

                        @foreach($kardexs->transactions as $kardex)
                    
                            <td>{{ $kardex->created_at }}</td>
                            <td>{{ $kardex->concepto->nombre }}</td>
                            <td>{{ $kardex->consecutivo }}</td>
                            <td>{{ $kardex->id }}</td>
                            
                                @switch( $kardex->concepto->transaccion_id )
                                    @case( 1 )
                                        <td></td>
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                    @break
                                    @case( 2 )
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                        <td></td>
                                    @break
                                    @case( 3 )
                                        <td></td>
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                    @break
                                    @case( 4 )
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                        <td></td>
                                    @break
                                    @case( 5 )
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                        <td></td>
                                    @break
                                    @case( 6 )
                                        <td></td>
                                        <td>{{ $kardex->pivot->cantidad }}</td>
                                    @break
                                    @default
                                        
                                    @break
                                @endswitch
                        
                            <td>{{ $kardex->pivot->costoventa }}</td>
                            <td>{{ $kardex->pivot->costopromedio }}</td>
                            <td>
                                @switch( $kardex->concepto->transaccion_id )
                                    @case( 1 )
                                        {{ $saldo = $saldo - $kardex->pivot->cantidad }}
                                    @break
                                    @case( 2 )
                                        {{ $saldo = $saldo + $kardex->pivot->cantidad }}
                                    @break
                                    @case( 3 )
                                        {{ $saldo = $saldo - $kardex->pivot->cantidad }}
                                    @break
                                    @case( 4 )
                                        {{ $saldo = $saldo + $kardex->pivot->cantidad }}
                                    @break
                                    @case( 5 )
                                        {{ $saldo = $saldo + $kardex->pivot->cantidad }}
                                    @break
                                    @case( 6 )
                                        {{ $saldo = $saldo - $kardex->pivot->cantidad }}
                                    @break
                                    @default
                                        
                                    @break
                                @endswitch
                            </td>
                    
                    </tr>
                        @endforeach
                
            </table>
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

        <script>
            $(document).ready( function () {
                $('#kardex').DataTable({
                    responsive:true,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                }
                },
                });
            });

    </script>

    @endsection








