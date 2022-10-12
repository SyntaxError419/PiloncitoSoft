@extends('layouts.plantillabase') 

@section('contenido')
@section('title', 'Registrar Medico')

<form action="/proveedores" method="POST">
   <!-- metodo >> --> @csrf

       <h2 class="pt-3">Crear medico</h2>
       <div class="card mt-4"> 
       <div class="card-header"> 
       <p class="text-danger">* Campo obligatorio.</p>
        <div class="card-body"> 
        <div class="row mb-3"> 

                <div class="col"> 
                <label for="" class="form-label">Nombre</label><label class="text-danger"> *</label>   
                <input  placeholder="Ingrese nombre(s) y spellidos" value="{{ old('nombre')}}"   minlength="3" maxlength="15" id="nombre" name="nombre" type="text" class="form-control" tabindex="1"> 
                @if($errors->has('nombre'))
                <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                @endif
               </div>
                  
  
            
                <div class="col">
              <label for="" class="form-label">Correo</label><label class="text-danger"> *</label>   
              <input  placeholder="Ingrese el correo electrónico" value="{{ old('correo')}}"   id="correo" name="correo" type="text" class="form-control" tabindex="2"> 
               @if($errors->has('correo'))
              <span class="error text-danger" for="input-name">{{$errors->first('correo')}}</span>
              @endif
               </div> 
               </div> 

              <div class="row mb-3">
              <div class="col">
              <label for="" class="form-label">Teléfono</label><label class="text-danger"> *</label>   
              <input minlength="7" maxlength="10" placeholder="Ingrese el numero de teléfono" value="{{ old('numero')}}"    onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numero" name="numero" type="text" class="form-control" tabindex="3"> 
              @if($errors->has('numero'))
             <span class="error text-danger" for="input-name">{{$errors->first('numero')}}</span>
             @endif
             </div>

             <div class="col"> 
            <label for="" class="form-label">Especialidad</label><label class="text-danger"> *</label>   
            <input  placeholder="Ingrese la especialidad" value="{{ old('especialidad')}}"  id="especialidad" name="especialidad" type="text" class="form-control" tabindex="4"> 
            @if($errors->has('especialidad'))
           <span class="error text-danger" for="input-name">{{$errors->first('especialidad')}}</span>
           @endif
           </div>
           </div>

            <div class="row mb-3"> 
            <div class="col">
            <label for="" class="form-label">Hospital</label><label class="text-danger"> *</label>   
            <input  placeholder="Ingrese el hospital" value="{{ old('hospital')}}"  id="hospital" name="hospital" type="text" class="form-control" tabindex="5"> 
            @if($errors->has('hospital'))
            <span class="error text-danger" for="input-name">{{$errors->first('hospital')}}</span>
            @endif
            </div>
            
            
            <div class="col">
            <label for="" class="form-label">Dirección del Hospital</label><label class="text-danger"> *</label>   
            <input  placeholder="Ingrese la dirrecion hospital" value="{{ old('direccionhospital')}}"  id="direccionhospital" name="direccionhospital" type="text" class="form-control" tabindex="6"> 
            @if($errors->has('direccionhospital'))
            <span class="error text-danger" for="input-name">{{$errors->first('direccionhospital')}}</span>
            @endif
            </div>
            
               
            
             
            </div>    
        </div>
      </div>  
    </div>     


  
   
   <a href="/proveedores" class="btn btn-secondary"tabindex="7"><i class="fas fa-backward"></i></a>
    <!-- <button style="float: ;" type="refresh" class="btn btn-secondary"  tabindex="4">Refrescar</button>  -->
   <button style="float: right;"  type="submit"  class="btn btn-success"   tabindex="8"><i class="fas fa-check"></i></button>
</form>

@endsection