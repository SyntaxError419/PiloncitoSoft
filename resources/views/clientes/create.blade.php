@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Cliente')
<form action="/clientes" method="POST">
    @csrf
    <h2 class="pt-3">Crear cliente</h2>
    <div class="card mt-4">
    <div class="card-header">
      
        <div class="card-body"> 
            <div class="row mb-3"> 

                <div class="col"> 
                  <label for="" class="form-label">Nombre</label>
                  <input id="nombre" name="nombre" type="text" class="form-control" tabindex="1" >
                  @if($errors->has('nombre'))
                    <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                   @endif
                </div>
  
            
                <div class="col">
                  <label for="" class="form-label">Cédula</label>
                  <input id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control" tabindex="2">
                  @if($errors->has('cedula'))
                   <span class="error text-danger" for="input-name">{{$errors->first('cedula')}}</span>
                  @endif
                </div>


            </div> 
            
            
            <div class="row mb-3">
                <div class="col">  
 
                  <label for="" class="form-label">Dirección</label>
                  <input list="direccion" name="direccion" type="text" class="form-control" tabindex="3" >
                  @if($errors->has('direccion'))
                    <span class="error text-danger" for="input-name">{{$errors->first('direccion')}}</span>
                  @endif
                </div>
                <div class="col"> 
                  <label for="" class="form-label">Contacto</label>
                  <input list="contacto" name="contacto" type="text" class="form-control" tabindex="4" >
                  @if($errors->has('contacto'))
                    <span class="error text-danger" for="input-name">{{$errors->first('contacto')}}</span>
                  @endif
                </div>

            </div>    
        </div>
      </div>  
    </div>     

  <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
  <button style="float: right;" type="submit"  class="btn btn-primary" tabindex="6">Guardar</button>
</form>

@endsection