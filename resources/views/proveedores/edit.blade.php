@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Editar proveedor')
<form action="/proveedores/{{$proveedores->id}}" method="POST">
@csrf
@method ('PUT')
<h2>Editar proveedor</h2>
<div class="card mt-4"> 
<div class="card-header"> 
<p class="text-danger"> Campo obligatorio (*).</p>
<div class="card-body"> 
<div class="row mb-3"> 


<div class="col">
<label for="" class="form-label">Nit/Cèdula</label><label class="text-danger"> *</label>
  
<input disabled minlength="10" maxlength="10" onkeypress="return event.charCode>= 48&& event.charCode <=57"  id="nit" name="nit" type="text" class="form-control" value="{{$proveedores->nit}}"> 
<!-- @if($errors->has('nit'))
<span class="error text-danger" for="input-name">{{$errors->first('nit')}}</span>
@endif -->
</div>


<div class="col">
<label for="" class="form-label">Nombre Contacto</label><label class="text-danger"> *</label>     
<input  minlength="3" maxlength="30" id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" value="{{$proveedores->nombrecontacto}}"> 
@if($errors->has('nombrecontacto'))
                <span class="error text-danger" for="input-name">{{$errors->first('nombrecontacto')}}</span>
                @endif
</div>
</div> 




<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Correo C</label><label class="text-danger"> *</label>     
<input id="correocontacto" name="correocontacto" type="text" class="form-control" value="{{ old('correocontacto',$proveedores->correocontacto) }}"> 
@if($errors->has('correocontacto'))
<span class="error text-danger" for="input-name">{{$errors->first('correocontacto')}}</span>
@endif
</div>



<div class="col">
<label for="" class="form-label">Nùmero Contacto</label><label class="text-danger"> *</label>   
<input maxlength="10"  onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto"  name="numerocontacto" type="text" class="form-control" value="{{$proveedores->numerocontacto}}">
@if($errors->has('numerocontacto'))
             <span class="error text-danger" for="input-name">{{$errors->first('numerocontacto')}}</span>
             @endif 
</div>
</div>



<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Empresa</label><label class="text-danger"> *</label>     
<input   id="empresa" name="empresa" type="text" class="form-control" value="{{$proveedores->empresa}}"> 
@if($errors->has('empresa'))
            <span class="error text-danger" for="input-name">{{$errors->first('empresa')}}</span>
            @endif
</div>


<div class="col">
<label for="" class="form-label">Direcciòn Empresa</label><label class="text-danger"> *</label>   
<input id="direccionempresa" name="direccionempresa" type="text" class="form-control" value="{{$proveedores->direccionempresa}}"> 
@if($errors->has('direccionempresa'))
           <span class="error text-danger" for="input-name">{{$errors->first('direccionempresa')}}</span>
           @endif
</div>




</div>    
        </div>
      </div>  
    </div>   
    <a href="/proveedores" class="btn btn-secondary"tabindex="5"><i class="fas fa-backward"></i></a>
    <button style="float: right;"  type="submit" class="btn btn-success"  tabindex="4"><i class="fas fa-check"></i></button> 
    </div>   


    
    



</form>
@section('js')

@if(session('error') == 'True')
    <script>
        Swal.fire(
        '¡Oops!',
        'El nit del proveedor ya está registrado, ingresa otro nit valido.',
        'error'
        ) 
        
    </script>
@endif

@endsection
@endsection