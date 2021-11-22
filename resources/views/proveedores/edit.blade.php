@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Editar proveedor')
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')
<h2>Editar proveedor</h2>
<div class="card mt-4"> 
<div class="card-header"> 
      
<div class="card-body"> 
<div class="row mb-3"> 


<div class="col">
<label for="" class="form-label">Nit/Cedula</label>   
<input disabled minlength="10" maxlength="10" onkeypress="return event.charCode>= 48&& event.charCode <=57"  id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}" tabindex="1"> 
<!-- @if($errors->has('nit'))
<span class="error text-danger" for="input-name">{{$errors->first('nit')}}</span>
@endif -->
</div>


<div class="col">
<label for="" class="form-label">Nombre Contacto</label>   
<input  minlength="3" maxlength="30" id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" value="{{$proveedores->nombrecontacto}}" tabindex="2"> 
</div>
</div> 




<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Correo C </label>   
<input id="correocontacto" name="correocontacto" type="text" class="form-control" value="{{ old('correocontacto',$proveedores->correocontacto) }}" tabindex="3"> 
@if($errors->has('correocontacto'))
<span class="error text-danger" for="input-name">{{$errors->first('correocontacto')}}</span>
@endif
</div>



<div class="col">
<label for="" class="form-label">Numero Contacto</label>   
<input minlength="3" maxlength="15"  onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto"  name="numerocontacto" type="text" class="form-control" value="{{$proveedores->numerocontacto}}"tabindex="4"> 
</div>
</div>



<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Empresa</label>   
<input  disabled id="empresa" name="empresa" type="text" class="form-control" value="{{$proveedores->empresa}}" tabindex="5"> 
</div>


<div class="col">
<label for="" class="form-label">Direccion Empresa</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" value="{{$proveedores->direccionempresa}}" tabindex="6"> 
</div>


</div>   
</div>  
        </div>
      </div>  
    </div>     


    
    <a href="/proveedores" class="btn btn-secondary" tabindex="7" ><i class="fas fa-backward"></i></a>
    <button style="float: right;"  type="submit" class="btn btn-success"  tabindex="8"><i class="fas fa-check"></i></button>



</form>

@endsection