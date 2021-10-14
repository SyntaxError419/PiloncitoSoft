@extends('layouts.plantillabase')

@section('contenido')

<h2>Crear Insumo</h2>


<form action="/insumos" method="POST">

@csrf

<div class="mb-3">
    <label for="" class="form-label">Nombre del insumo </label>
    <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control" tabindex="1"  required="required" >  
</div>


<div class="mb-3">
    <label for="" class="form-label">Cantidad</label>
    <input id="cantidad" name="cantidad" type="number"   class="form-control" tabindex="2"  required="required" >  
</div>





<a href="/insumos" class="btn btn-secondary" tabindex="3">Cancelar</a>
<button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

</form>
    


@endsection