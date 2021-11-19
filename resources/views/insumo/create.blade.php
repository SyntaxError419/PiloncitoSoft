@extends('layouts.plantillabase')

@section('contenido')
<form action="/insumos" method="POST">
@csrf

<h2 class="ml-3">Crear Insumo</h2>


<div class="card-body">

<div class="card">

<div class="card-header">


<div class="mb-3">
    <label for="" class="form-label">Nombre del insumo </label>
    <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control" tabindex="1"  required="required" >  
</div>


<div class="mb-3">
    <label for="" class="form-label">Cantidad</label>
    <input   onkeypress="return event.charCode>= 48&& event.charCode <=57" id="cantidad" name="cantidad" type="number"  value ="0"  class="form-control" tabindex="2"  required="required" >  
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