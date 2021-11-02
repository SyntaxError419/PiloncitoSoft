@extends('layouts.plantillabase')

@section('contenido')

<h1 text align="center">Detalle registro</h1>
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')


<div class="mb-3">
<label for="" class="form-label">Nit</label>   
<input  disabled onkeypress="return event.charCode>= 48&& event.charCode <=57"  id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Nombre Contacto</label>   
<input id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" disabled value="{{$proveedores->nombrecontacto}}"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Correo</label>   
<input id="correocontacto" name="correocontacto" type="text" class="form-control" disabled  value="{{$proveedores->correocontacto}}"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Numero Contacto</label>   
<input onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto" name="numerocontacto" type="text"  disabled class="form-control" value="{{$proveedores->numerocontacto}}"> 
</div>

<div class="mb-3">
<label for="" class="form-label">Empresa</label>   
<input id="empresa" name="empresa" type="text" class="form-control" disabled value="{{$proveedores->empresa}}"> 
</div>

<div class="mb-3">
<label for="" class="form-label">Direccion Empresa</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" disabled value="{{$proveedores->direccionempresa}}"> 
</div>
    
<a href="/proveedores" class="btn btn-danger"><i class="fas fa-backward"></i> Cancelar</a>
<button  type="submit" class="btn btn-success"  tabindex="4 "><i class="fas fa-save"></i> Guardar </button>



</form>

@endsection