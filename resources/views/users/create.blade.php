@extends('layouts.plantillabase') 

@section('contenido')
<h1 text align= "Center">Crear un usuario</h1>
<br>

<form action="/users" method="POST">

<!-- metodo >> --> @csrf

<div class="mb-3">
<label for="" class="form-label">Nombre</label>   
<input id="name" name="name" type="text" class="form-control" tabindex="1"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Correo</label>   
<input id="email" name="email" type="text" class="form-control" tabindex="2"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Password</label>   
<input id="password" name="password" type="password" class="form-control" tabindex="2"> 
</div>

<div class="mb-3">
<label for="" class="form-label">Confirm Password</label>   
<input id="password" name="password" type="password" class="form-control" tabindex="2"> 
</div>


    
<a href="/users" class="btn btn-danger" tabindex="5"><i class="fas fa-backward"></i> Cancelar</a>
<button type="refresh" class="btn btn-primary" tabindex="4 "><i class="fas fa-sync-alt"></i> Refrescar</button>
<button  type="submit" class="btn btn-success"  tabindex="4 "><i class="fas fa-save"></i> Guardar </button>


</form>
@endsection