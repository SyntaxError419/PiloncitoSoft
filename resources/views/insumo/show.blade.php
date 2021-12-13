@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Insumo')

<center><h2>Detalles de Insumo</h2> </center>


<form action="/insumos/{{$insumo->id}}" method="POST">
@csrf   
@method('PUT')

<div class="card">
        
        <div class="card-header">
                      
<div class="mb-3">
    <label for="" class="form-label">Nombre del insumo </label>
    <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control"  value="{{$insumo-> nombre_insumo}}" disabled="true">  
</div>




<div class="mb-3">
    <label for="" class="form-label">Cantidad</label>
    <input id="cantidad" name="cantidad" type="number"   class="form-control" value="{{$insumo-> cantidad}}" disabled="true">   
</div>



<div class="mb-3">
    <label for="" class="form-label">Estado</label>

    @if ($insumo->estado == 1)
                      
    <input id="estado" name="estado" type="text" step="any"  class="form-control"  value="Activo" disabled="true">  
    
     @else
    <input id="estado" name="estado" type="text" step="any"  class="form-control"  value="Desactivado" disabled="true">  
     @endif

</div>


</div>
</div>
<a href="/insumos" class="btn btn-secondary" tabindex="3"style="float: left;"><i class="fas fa-backward"></i></a>

</form>



@endsection
