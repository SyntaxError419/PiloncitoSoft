@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Detalle proveedor')
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')
<h2 text align="center">Detalle proveedor</h2 >
<div class="card mt-4"> 
<div class="card-header"> 
      
<div class="card-body"> 
<div class="row mb-3"> 


<div class="col">
<label for="" class="form-label">Nit/Cedula</label>   
<input  disabled   id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}"> 
</div>


<div class="col">
<label for="" class="form-label">Nombre Contacto</label>   
<input id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" disabled value="{{$proveedores->nombrecontacto}}"> 
</div>
</div>


<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Correo C </label>   
<input id="correocontacto" name="correocontacto" type="text" class="form-control" disabled  value="{{$proveedores->correocontacto}}"> 
</div>


<div class="col">
<label for="" class="form-label">Numero Contacto</label>   
<input  id="numerocontacto" name="numerocontacto" type="text"  disabled class="form-control" value="{{$proveedores->numerocontacto}}"> 
</div>
</div>

<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Empresa</label>   
<input id="empresa" name="empresa" type="text" class="form-control" disabled value="{{$proveedores->empresa}}"> 
</div>

<div class="col">
<label for="" class="form-label">Direccion Empresa</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" disabled value="{{$proveedores->direccionempresa}}"> 
</div>
   
        </div>
        </div>
      </div>  
    </div>  

    <a href="/proveedores" class="btn btn-secondary"tabindex="5">Cancelar</a>
    <button style="float: right;"  type="submit" class="btn btn-primary"  tabindex="4">Guardar</button>



</form>

@endsection