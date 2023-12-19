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
                            
                        <h1 class="page__heading">Informes</h1>
                            
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
                                            <li class="list-group-item active" aria-current="true">Listado</li>
                                            <li class="list-group-item"><i class="fa-regular fa-hand-point-right fa-1x"></i> <a href="{{ route('informe.load') }}">Informe fiscal</a></li>
                                            <!--<li class="list-group-item">A third item</li>
                                            <li class="list-group-item">A fourth item</li>
                                            <li class="list-group-item">And a fifth one</li>-->
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

        
    

    @endsection








