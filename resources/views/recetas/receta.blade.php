@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

@endsection

@section('content')
    <section class="section">
        <div class="section-header">
        
            <h3 class="page__heading">Receta</h3>
        
        </div>
        <div class="section-body">
            
            <div class="row">

                <div class="card col-6">

                    {!! Form::open(array('route' => 'receta.addProduct','method'=>'POST')) !!}

                        <div>
                            <label for="receta">Producto</label>
                            {!! Form::text('producto',null,['class' => 'typeahead form-control', 'id' => 'producto']) !!}
                            {!! Form::hidden('producto_id',null,['class' => 'typeahead form-control', 'id' => 'producto_id']) !!}
                        </div>

                        <div class="col-6">
                            <button type="submit" name="grabar" id="grabar" class="btn btn-dark btn-lg btn-block"><i class="fa-solid fa-circle-plus fa-lg"></i></button>
                        </div>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>
        
    </section>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
//Autocompletar productos
    srcProductos = "{{ route('facturacion.searchServiceProduct') }}"
    $("#producto").autocomplete({
        source: function( request, response ) {
        
            $.ajax({
            url: srcProductos,
            type: 'GET',
            dataType: "json",
            data: {
                search: request.term
            },
        
            success: function( data ) {
                
                //console.log(data)
                
                response($.map(data, function(item) {
        
                                    return {
                    
                                        label: item.nombre,
                                        value: item.id,   
                                        
                                    };

                                }
                ));
                
            }
            });
        },
        
        select: function (event, ui) {
        
            $('#producto').val(ui.item.label);
            $('#producto_id').val(ui.item.value);
            
            //console.log($('#producto_id').val()); 

            return false;
        }

    });
//Fin Autocompletar productos


</script>
@endsection