@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Proveedor')
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')
<h1 text align="center">Editar proveedor</h1>
<div class="card mt-4"> 
<div class="card-header"> 
      
<div class="card-body"> 
<div class="row mb-3"> 


<div class="col">
<label for="" class="form-label">Nit/Cedula</label>   
<input disabled minlength="10" maxlength="10" onkeypress="return event.charCode>= 48&& event.charCode <=57"  id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}"> 
<!-- @if($errors->has('nit'))
<span class="error text-danger" for="input-name">{{$errors->first('nit')}}</span>
@endif -->
</div>


<div class="col">
<label for="" class="form-label">Nombre Contacto</label>   
<input  minlength="3" maxlength="30" id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" value="{{$proveedores->nombrecontacto}}"> 
</div>
</div> 




<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Correo C </label>   
<input id="correocontacto" name="correocontacto" type="text" class="form-control" value="{{ old('correocontacto',$proveedores->correocontacto) }}"> 
@if($errors->has('correocontacto'))
<span class="error text-danger" for="input-name">{{$errors->first('correocontacto')}}</span>
@endif
</div>



<div class="col">
<label for="" class="form-label">Numero Contacto</label>   
<input minlength="3" maxlength="15"  onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto"  name="numerocontacto" type="text" class="form-control" value="{{$proveedores->numerocontacto}}"> 
</div>
</div>


<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Empresa</label>   
<input  disabled id="empresa" name="empresa" type="text" class="form-control" value="{{$proveedores->empresa}}"> 
</div>


<div class="col">
<label for="" class="form-label">Direccion Empresa</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" value="{{$proveedores->direccionempresa}}"> 
</div>


</div>    
        </div>
      </div>  
    </div>     


    
    <a href="/proveedores" class="btn btn-secondary"tabindex="5">Cancelar</a>
    <button style="float: right;"  type="submit" class="btn btn-primary"  tabindex="4">Guardar</button>



</form>

@endsection