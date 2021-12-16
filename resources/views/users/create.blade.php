@extends('layouts.plantillabase') 

@section('contenido')
<form action="/users" method="POST">
<!-- metodo >> --> @csrf

<h2 class="pt-3">Crear usuario</h2>
       <div class="card mt-4"> 
       <div class="card-header"> 
       <p class="text-danger"> Campo obligatorio (*).</p>
        <div class="card-body"> 
        <div class="row mb-3"> 






<div class="col"> 
<label for="" class="form-label">Nombre</label><label class="text-danger"> *</label>   
<input id="name" name="name" type="text" class="form-control" tabindex="1"> 
</div>

<div class="col">
<label for="" class="form-label">Correo</label><label class="text-danger"> *</label>    
<input id="email" name="email" type="text" class="form-control" tabindex="2"> 
</div>
</div> 

<div class="row mb-3">
<div class="col">
<label for="" class="form-label">Password</label><label class="text-danger"> *</label>   
<input id="password" name="password" type="password" class="form-control" tabindex="2"> 
</div>


<div class="col">
<label for="" class="form-label">Confirm Password</label><label class="text-danger"> *</label>  
<input id="password" name="password" type="password" class="form-control" tabindex="2"> 
</div>

     
</div> 
        </div>
      </div>  
    </div>     

    
<a href="/users" class="btn btn-secondary"tabindex="7"><i class="fas fa-backward"></i></a>
<button style="float: right;"  type="submit"  class="btn btn-success"   tabindex="8"><i class="fas fa-check"></i></button>
</form>
@section('js')


@if(session('errorregistro') == 'errorregistro')
    <script>
        Swal.fire(
        '¡Oops!',
        'El nombre del usuario ya se encuentra registrado.',
        'error'
        ) 
    </script>
@endif

@endsection
@endsection