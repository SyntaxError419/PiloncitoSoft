@extends('layouts.plantillabase')

@section('contenido')

<h1 text align="center">Editar registro</h1>
<form action="/users/{{$users->id}}" method="POST">
@csrf
@method ('PUT')


<div class="mb-3">
<label for="" class="form-label">Nombre</label>   
<input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{$users->name}}"> 
</div>


<div class="mb-3">
<label for="" class="form-label">Correo</label>   
<input id="email" name="email" type="text" class="form-control" tabindex="2" value="{{$users->email}}" > 
</div>


<div class="mb-3">
<label for="" class="form-label">Password</label>   
<input id="password" name="password" type="password" class="form-control" tabindex="2"> 
</div>
    
<a href="/proveedores" class="btn btn-danger"><i class="fas fa-backward"></i> Cancelar</a>
<button  type="submit" class="btn btn-success"  tabindex="4 "><i class="fas fa-save"></i> Guardar </button>



</form>

@endsection