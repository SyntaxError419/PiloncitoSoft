@extends('layouts.plantillabase')

@section('contenido')
<form action="/clientes" method="POST">
    @csrf
  <div class="mb-3">
    <label for="" class="form-label">Nombre</label>
    <input id="nombre" name="nombre" type="text" class="form-control" tabindex="1" required="required">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Cédula</label>
    <input id="cedula" name="cedula" type="text"  class="form-control" tabindex="2" required="required">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Dirección</label>
    <input list="direccion" name="direccion" type="text" class="form-control" tabindex="3" required="required">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Contacto</label>
    <input list="contacto" name="contacto" type="text" class="form-control" tabindex="4" required="required">
  </div>
  <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
  <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
</form>

@endsection