@extends('layouts.plantillabase')

@section('contenido')

<h2>Editar Compra</h2>


<form action="/insumos/{{$insumo->id}}" method="POST">
@csrf   
@method('PUT')

<div class="mb-3">
    <label for="" class="form-label">Nombre del insumo </label>
    <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control"  value="{{$insumo-> nombre_insumo}}" required="required">  
</div>




<div class="mb-3">
    <label for="" class="form-label">Cantidad</label>
    <input id="cantidad" name="cantidad" type="number"   class="form-control" value="{{$insumo-> cantidad}}" required="required">  
</div>






<a href="/insumos" class="btn btn-secondary" >Cancelar</a>
<button type="submit" class="btn btn-primary" >Guardar</button>

</form>



@endsection