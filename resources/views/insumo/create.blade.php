@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Insumo')
<form action="/insumos" method="POST">
@csrf

<h2 class="ml-3">Crear Insumo</h2>
<h10 class="ml-3">Los campos marcados con * son obligatorios.</h10>




<div class="card-body">

        <div class="card">

                    <div class="card-header">



                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label">Nombre del insumo:  * </label>
                                    <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control" tabindex="1"  required="required" placeholder="Ingrese un nombre para el Insumo" >  
                                </div>


                                <div class="col">
                                    <label for="" class="cantidad form-label">Cantidad:</label>
                                    <input   onkeypress="return event.charCode>= 48&& event.charCode <=57" id="cantidad" name="cantidad" type="number"   class="form-control" tabindex="2"  required="required" placeholder="Ingrese una cantidad" >  
                                </div>


                            </div>


                    </div>

        </div>


    <a href="/insumos" class="btn btn-secondary" tabindex="3"style="float: left;"><i class="fas fa-backward"></i></a>
    <button style="float: right;" type="submit" class="btn btn-success" tabindex="4"><i class="fas fa-check"></i></button>
</div>
</form>

@section('js')

@if(session('error') == 'True')
    <script>
        Swal.fire(
        '¡Oops!',
        'El nombre del insumo ya está registrado, ingresa otro nombre.',
        'error'
        ) 
    </script>
@endif

@endsection
@endsection 