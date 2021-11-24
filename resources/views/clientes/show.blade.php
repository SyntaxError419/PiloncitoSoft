@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Cliente')

<h2 class="pt-3">Detalle del producto</h2>

<div class="card mt-4">
    <div class="card-header">
            <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Nombre</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$cliente->nombre}}">
                            <input type="hidden" id="nombre" name="nombre"   class="form-control" value="{{$cliente->nombre}}">  
                            
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Cédula</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$cliente->cedula}}">
                            <input type="hidden"  id="cedula" name="cedula"   class="form-control" value="{{$cliente->cedula}}">  
                            
                        </div>
            </div>            

                        <div class="row mb-3">
                            <div class="col">
                                <label for="" class="form-label">Dirección</label>
                                <input disabled="true" id="direccion" name="direccion" type="text" class="form-control" value="{{$cliente->direccion}}" >
                                <input type="hidden"  id="direccion" name="direccion"   class="form-control" value="{{$cliente->direccion}}">  
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Contacto</label>
                                <input disabled="true" id="contacto" name="contacto" type="text" class="form-control" value="{{$cliente->contacto}}">
                                <input type="hidden"  id="contacto" name="contacto"   class="form-control" value="{{$cliente->contacto}}">  
                            </div>
                        </div>
    </div>
</div>
                        
<a href="/clientes" class="btn btn-secondary"><i class="fas fa-backward"></i></a>                         
                       
                        
        
        
@endsection