@extends('layouts.plantillabase')

@section('contenido')
<form action="/clientes/{{$cliente->id}}" method="POST">
    @csrf
    @method('PUT')
    <h2 class="pt-3">Editar cliente</h2>
    <div class="card mt-4">
    <div class="card-header">

    <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Nombre</label>
                    <input id="nombre" name="nombre" type="text" class="form-control" value="{{$cliente->nombre}}" tabindex="1" required="required">
                </div>
                <div class="col">
                    <label for="" class="form-label">Cédula</label>
                    <input id="cedula" name="cedula" type="text"  class="form-control" value="{{$cliente->cedula}}"tabindex="2" required="required">
                </div>
            </div>    
            <div class="row mb-3">
                <div class="col">
                  <label for="" class="form-label">Dirección</label>
                  <input list="direccion" name="direccion" type="text" class="form-control" value="{{$cliente->direccion}}" tabindex="3" required="required">
                </div>
                <div class="col">
                  <label for="" class="form-label">Contacto</label>
                  <input list="contacto" name="contacto" type="text" class="form-control" value="{{$cliente->contacto}}" tabindex="4" required="required">
                </div>
            </div>
          </div>
        </div>
      </div>  
  <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
  <button style="float: right;" type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
</form>

@endsection