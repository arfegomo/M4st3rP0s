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
                            
                        <h1 class="page__heading">Mesas</h1>
                            
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

                        <div class="row">

                            @foreach($mesas as $mesa)

                                @if($mesa->id != 1000)

                                @php 
                                    $value = \Illuminate\Support\Facades\DB::table('temporaries')->where('mesa_id', $mesa->id)->exists()
                                @endphp

                                    @if($value == 1)

                                    <div class="col-lg-2">

                                        <form method="POST" action="{{ route('facturacion.close') }}">

                                            @csrf
            
                                            <input type="hidden" name="mesa" value="{{ $mesa->id }}"/>

                                                @php 
                                                    $consecutivo = \Illuminate\Support\Facades\DB::table('temporaries')->where('mesa_id', $mesa->id)->value('consecutivo_id')
                                                @endphp 

                                                <div class="col-lg-2">

                                                    <button type="submit" class="btn btn-danger btn-lg active btn-block" role="button" aria-pressed="true"><b>Mesa: {{ $mesa->id }} </b><br><img alt="image" src="{{ asset('img/mesa.png') }}"><br><span>{{ $mesa->responsable }}</span></button><hr>

                                                </div>

                                                <input type="hidden" name="consecutivo" value="{{ $consecutivo }}"/>

                                        </form>

                                    </div>

                                            @else

                                        <div class="col-lg-2">
    
                                                    <div class="col-lg-2">
    
                                                        <button type="button" data-id="{{ $mesa->id }}" id="openModal" class="btn btn-linght btn-lg active btn-block" role="button" aria-pressed="true"><b>Mesa: {{ $mesa->id }} </b><br><img alt="image" src="{{ asset('img/mesa.png') }}"><br><span>{{ $mesa->responsable }}</span></button>
    
                                                    </div>
    

                                        </div>

                                    @endif

                                @endif

                            @endforeach                            

                        </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            

            <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
            
                <div class="modal-content">
            
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Responsable de la mesa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body">

                        <form action="{{ route('mesa.updateMesa') }}" method="POST">

                            @csrf
                            @method('PUT')
                    
                            <div class="col-lg-12">
                                
                                <div class="form-group">
                                    <label for="responsable">Nombre</label>
                                    <input type="text" name="responsable" class="form-control" id="subtotal" value="">
                                </div>

                                <div class="form-group">
                                    <label for="mesa">Mesa</label>
                                    <input type="text" name="mesa-id" id="mesa-id" class="form-control" readonly>
                                </div>
                            
                            </div>


                            <div class="modal-footer">
                            
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" id="grabar" class="btn btn-primary">Grabar</button>

                            </div>

                        </form>

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
        
        //Llamar modal
        $(document).on('click','#openModal',function(e){

            idMesa = $(this).attr("data-id");

            $("#mesa-id").val(idMesa);

            $('#exampleModal').modal('show'); //abrir

        });    
        //Fin llamado modal

        </script>   
    

    @endsection








