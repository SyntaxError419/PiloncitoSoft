@extends('layouts.plantillabase')

@section('contenido')

<h1 text align="center">Editar proveedor</h1>
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')


<div class="mb-3">
<label for="" class="form-label">Nit</label>   
<input disabled minlength="10" maxlength="10" onkeypress="return event.charCode>= 48&& event.charCode <=57"  id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}"> 
<!-- @if($errors->has('nit'))
<span class="error text-danger" for="input-name">{{$errors->first('nit')}}</span>
@endif -->
</div>


<div class="mb-3">
<label for="" class="form-label">Nombre Contacto</label>   
<input  minlength="3" maxlength="30" id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" value="{{$proveedores->nombrecontacto}}"> 
</div>



<div class="mb-3">
<label for="" class="form-label">Correo</label>   
<input id="correocontacto" name="correocontacto" type="text" class="form-control" value="{{ old('correocontacto',$proveedores->correocontacto) }}"> 
@if($errors->has('correocontacto'))
<span class="error text-danger" for="input-name">{{$errors->first('correocontacto')}}</span>
@endif
</div>



<div class="mb-3">
<label for="" class="form-label">Numero Contacto</label>   
<input minlength="3" maxlength="15"  onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto"  name="numerocontacto" type="text" class="form-control" value="{{$proveedores->numerocontacto}}"> 
</div>

<div class="mb-3">
<label for="" class="form-label">Empresa</label>   
<input  disabled id="empresa" name="empresa" type="text" class="form-control" value="{{$proveedores->empresa}}"> 
</div>

<div class="mb-3">
<label for="" class="form-label">Direccion Empresa</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" value="{{$proveedores->direccionempresa}}"> 
</div>
    
<a href="/proveedores" class="btn btn-danger"><i class="fas fa-backward"></i> Cancelar</a>
<button  type="submit" class="btn btn-success" onclick="return confirm ('¿Estas seguro que deseas editar este registro?')"  tabindex="4 "><i class="fas fa-save"></i> Guardar </button>



</form>

@endsection