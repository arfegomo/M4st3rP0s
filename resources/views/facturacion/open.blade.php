@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

@endsection

@section('content')

<section class="section">
    
    <section class="section">
    
        <div class="section-header">

            <div class="row">

                <div class="col-lg-12">
                        
                    <h1 class="page__heading">Facturación</h1>
                        
                </div> 

            </div>

        </div>

        <div class="section-body">

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <table id="departamentos" class="table table-bordered shadow-lg mt-4" style="width:100%">
                            <thead class="bg bg-dark">            
                                <tr>
                                    <th style='color:#fff;'>Transacciones abiertas</th>
                                    <th style='color:#fff;'>Socio del negocio</th>
                                    <th style='color:#fff;'>Mesa</th>
                                    <th style='color:#fff;'>Acciones</th>
                                </tr>
                            </thead>
            
                            <tr>
                        @foreach($temporaries as $temporary)
                            
                            <td>{{ $temporary->consecutivo_id }}</td>
                            <td>{{ $temporary->socios }}</td>
                            <td>{{ $temporary->mesa->id }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    
                                    <form method="POST" action="{{ route('facturacion.close') }}">

                                        <input type="hidden" name="consecutivo" value="{{$temporary->consecutivo_id}}"/>

                                        @csrf

                                        <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-pencil-alt"></i></button>                                     

                                    </form>
                                
                                </div>
                            </td>
                            </tr>
                        @endforeach
                            
                        </table>

                    </div>
                </div>
            </div>
        </div>
    
    </section>
@endsection







