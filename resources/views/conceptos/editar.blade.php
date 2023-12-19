@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar concepto</h3>
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
                
                {!! Form::model($concepto, ['route' => ['conceptos.update', $concepto->id],'method'=>'PUT']) !!}                        

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                {!! Form::text('nombre',null,array(
                                    'class'=>'form-control',
                                    'required'=>'required',
                                    'placeholder'=>'Nombre'
                                )) !!}
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="transaccion" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de transacción') }}</label>
                                    <div class="col-md-6">
                                        {!! Form::select('transaccion_id', $transacciones ,null, ['class' => 'form-control']) !!}
                                    </div>
                            </div>

                            <div class="form-group row">
                                <label for="caja" class="col-md-4 col-form-label text-md-right">{{ __('Afecta caja') }}</label>
                                    <div class="col-md-6">
                                          <select name="afectacaja" class="form-control">
                                            
                                                @if($concepto->afectacaja == 1)
                                                    <option value="1" selected>Si</option>
                                                    <option value="2">No</option>
                                                @elseif($concepto->afectacaja == 2)
                                                    <option value="1">Si</option>
                                                    <option value="2" selected>No</option>
                                                @endif

                                          </select>
                                    </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="inventario" class="col-md-4 col-form-label text-md-right">{{ __('Afecta inventario') }}</label>
                                    <div class="col-md-6">
                                          <select name="afectainventario" class="form-control">

                                                @if($concepto->afectainventario == 1)
                                                    <option value="1" selected>Si</option>
                                                    <option value="2">No</option>
                                                @elseif($concepto->afectainventario == 2)
                                                    <option value="1">Si</option>
                                                    <option value="2" selected>No</option>
                                                @endif

                                          </select>
                                    </div>
                            </div>

                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Modalidad') }}</label>
                                    <div class="col-md-6">
                                          <select name="tipo" class="form-control">

                                            @if($concepto->tipo == 0)
                                                <option value="0" selected>No aplica</option>
                                                <option value="1">Contado</option>
                                                <option value="2">Crédito</option>
                                            @elseif($concepto->tipo == 1)
                                                <option value="0">No aplica</option>
                                                <option value="1" selected>Contado</option>
                                                <option value="2">Crédito</option>
                                            @elseif($concepto->tipo == 2)
                                                <option value="0">No aplica</option>
                                                <option value="1">Contado</option>
                                                <option value="2" selected>Crédito</option>
                                            @endif

                                          </select>
                                    </div>
                            </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Grabar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
@endsection