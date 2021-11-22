@extends('layouts.plantillabase') 

@section('contenido')
@section('title', 'Proveedor')

<form action="/proveedores" method="POST">
   <!-- metodo >> --> @csrf

       <h2 class="pt-3">Crear proveedor</h2>
       <div class="card mt-4"> 
       <div class="card-header"> 
      
        <div class="card-body"> 
        <div class="row mb-3"> 

                <div class="col"> 
                  <label for="" class="form-label">Nit/Cedula</label>
                  <input minlength="10" maxlength="10"  placeholder="Ingrese NIT o Cedula" value="{{ old('nit')}}" onkeypress="return event.charCode>= 48&& event.charCode <=57" id="nit" name="nit" type="text" class="form-control" tabindex="1"> 
                  @if($errors->has('nit'))
                  <span class="error text-danger" for="input-name">{{$errors->first('nit')}}</span>
                  @endif
                  </div>
  
            
                <div class="col">
                <label for="" class="form-label">Nombre Contacto</label>   
                <input  placeholder="Ingrese el Nombre y Apellidos" value="{{ old('nombrecontacto')}}"   minlength="3" maxlength="15" id="nombrecontacto" name="nombrecontacto" type="text" class="form-control" tabindex="2"> 
                @if($errors->has('nombrecontacto'))
                <span class="error text-danger" for="input-name">{{$errors->first('nombrecontacto')}}</span>
                @endif
               </div>
               </div> 
            

              <div class="row mb-3">
              <div class="col">
              <label for="" class="form-label">Correo C</label>   
              <input  placeholder="Ingrese el Correo Electronico" value="{{ old('correocontacto')}}"   id="correocontacto" name="correocontacto" type="text" class="form-control" tabindex="3"> 
               @if($errors->has('correocontacto'))
              <span class="error text-danger" for="input-name">{{$errors->first('correocontacto')}}</span>
              @endif
              </div>

                
                
              <div class="col">
              <label for="" class="form-label">Numero Contacto</label>   
              <input minlength="7" maxlength="10" placeholder="Ingrese el Numero De telefono" value="{{ old('numerocontacto')}}"    onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numerocontacto" name="numerocontacto" type="text" class="form-control" tabindex="4"> 
              @if($errors->has('numerocontacto'))
             <span class="error text-danger" for="input-name">{{$errors->first('numerocontacto')}}</span>
             @endif
             </div>
             </div>


            <div class="row mb-3"> 
            <div class="col">
            <label for="" class="form-label">Empresa</label>   
            <input  placeholder="Ingrese la Empresa" value="{{ old('empresa')}}"  id="empresa" name="empresa" type="text" class="form-control" tabindex="5"> 
            @if($errors->has('empresa'))
            <span class="error text-danger" for="input-name">{{$errors->first('empresa')}}</span>
            @endif
            </div>
            

            <div class="col"> 
            <label for="" class="form-label">Direccion Empresa</label>   
            <input  placeholder="Ingrese La Direccion de la Empresa" value="{{ old('direccionempresa')}}"  id="direccionempresa" name="direccionempresa" type="text" class="form-control" tabindex="6"> 
            @if($errors->has('direccionempresa'))
           <span class="error text-danger" for="input-name">{{$errors->first('direccionempresa')}}</span>
           @endif
           </div>   
            
             
            </div>    
        </div>
      </div>  
    </div>     


  
   
   <a href="/proveedores" class="btn btn-secondary"tabindex="5">Cancelar</a>
    <!-- <button style="float: ;" type="refresh" class="btn btn-secondary"  tabindex="4">Refrescar</button>  -->
   <button style="float: right;"  type="submit" class="btn btn-primary"  tabindex="4">Guardar</button>
</form>

@endsection