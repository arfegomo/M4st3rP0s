@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear transacción</h3>
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
                        {!! Form::open(array('route' => 'transacciones.store','method'=>'POST')) !!}
                        

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

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
                            <label for="caja" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de operación en caja') }}</label>
                                <div class="col-md-6">
                                      <select name="caja" class="form-control">
                                        <option value="0">No aplica</option>
                                        <option value="1">Suma</option>
                                        <option value="2">Resta</option>
                                      </select>
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="inventario" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de operación en inventario') }}</label>
                                <div class="col-md-6">
                                      <select name="inventario" class="form-control">
                                        <option value="0">No aplica</option>
                                        <option value="1">Suma</option>
                                        <option value="2">Resta</option>
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