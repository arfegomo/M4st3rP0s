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
                            
                        <h1 class="page__heading">Inventarios</h1> | 
                            |
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

            <table id="inventarios" class="table table-bordered shadow-lg mt-4" style="width:100%">
                <thead class="bg bg-dark">            
                    <tr>
                        <th style='color:#fff;'>Producto</th>
                        <th style='color:#fff;'>Tipo de producto</th>
                        <th style='color:#fff;'>Existencia actual</th>
                        <th style='color:#fff;'>Costo actual actual</th>
                        <th style='color:#fff;'>Acciones</th>
                    </tr>
                </thead>

                <tr>
            @foreach($inventarios as $inventario)
                
                <td>{{ $inventario->nombre }}</td>
                <td>
                    
                    @if( $inventario->tipoproducto == 1)

                        Inventario

                    @else

                        Servicios

                    @endif

                </td>
                <td>{{ $inventario->existenciactual }}</td>
                <td>{{ $inventario->costoactual }}</td>
                <td>

                    <div class="btn-group" role="group">
                        
                        @can('ver-inventario')
                            <a class="btn btn-primary" href="{{ route('inventario.kardex',$inventario->id) }}">
                            <i class="fas fa-pencil-alt"></i></a> 
                        @endcan 
                    
                    </div>

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
                $('#inventarios').DataTable({
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








