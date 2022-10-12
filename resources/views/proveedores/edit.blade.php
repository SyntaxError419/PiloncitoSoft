@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Editar medico')
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')
<h2>Editar medico</h2>
<div class="card mt-4"> 
<div class="card-header"> 
      
<div class="card-body"> 
<div class="row mb-3"> 





<div class="col">
<label for="" class="form-label">Nombre </label>   
<input  minlength="3" maxlength="30" id="nombre" name="nombre" type="text" class="form-control" value="{{$proveedores->nombre}}"> 
</div>

<div class="col">
<label for="" class="form-label">Correo </label>   
<input id="correo" name="correo" type="text" class="form-control" value="{{ old('correo',$proveedores->correo) }}"> 
@if($errors->has('correo'))
<span class="error text-danger" for="input-name">{{$errors->first('correo')}}</span>
@endif
</div>
</div> 




<div class="row mb-3">

<div class="col">
<label for="" class="form-label">Numero</label>   
<input minlength="3" maxlength="15"  onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numero"  name="numero" type="text" class="form-control" value="{{$proveedores->numero}}"> 
</div>

<div class="col">
<label for="" class="form-label">Especialidad </label>   
<input  minlength="3" maxlength="30" id="especialidad" name="especialidad" type="text" class="form-control" value="{{$proveedores->especialidad}}"> 
</div>

</div>





<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Hospital</label>   
<input  disabled id="hospital" name="hospital" type="text" class="form-control" value="{{$proveedores->hospital}}"> 
</div>


<div class="col">
<label for="" class="form-label">Direccion Hospital</label>   
<input id="direccionhospital" name="direccionhospital" type="text" class="form-control" value="{{$proveedores->direccionhospital}}"> 
</div>




</div>    
        </div>
      </div>  
    </div>   
    <a href="/proveedores" class="btn btn-secondary"tabindex="5"><i class="fas fa-backward"></i></a>
    <button style="float: right;"  type="submit" class="btn btn-success"  tabindex="4"><i class="fas fa-check"></i></button> 
    </div>   


    
    



</form>

@endsection