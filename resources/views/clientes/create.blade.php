@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Cliente')

    <h2 class="pt-3">Crear cliente</h2>
    <div class="card mt-4">
    <div class="card-header">
    <form action="/clientes" method="POST" class="crearClt">
    @csrf
    <span class="error text-danger pt-3">*Campo Obligatorio</span>
        <div class="card-body"> 
        
            <div class="row mb-3"> 

                <div class="col"> 
                  <label for="" class="block font-medium text-sm text-gray-700" >Nombre</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre')}}" tabindex="1" >
                  @if($errors->has('nombre'))
                    <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                   @endif
                </div>
  
            
                <div class="col">
                  <label for="" class="block font-medium text-sm text-gray-700">Cédula</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control" value="{{ old('cedula')}}" tabindex="2">
                  @if($errors->has('cedula'))
                   <span class="error text-danger" for="input-name">{{$errors->first('cedula')}}</span>
                  @endif
                </div>


            </div> 
            
            
            <div class="row mb-3">
                <div class="col">  
 
                  <label for="" class="block font-medium text-sm text-gray-700">Dirección</label>
                  <label for="" class="error text-danger" >*</label>
                  <input list="direccion" name="direccion" type="text" class="form-control" value="{{ old('direccion')}}" tabindex="3" >
                  @if($errors->has('direccion'))
                    <span class="error text-danger" for="input-name">{{$errors->first('direccion')}}</span>
                  @endif
                </div>
                <div class="col"> 
                  <label for="" class="form-label">Contacto</label>
                  <label for="" class="error text-danger" >*</label>
                  <input list="contacto" name="contacto" type="text" class="form-control" value="{{ old('contacto')}}" tabindex="4" >
                  @if($errors->has('contacto'))
                    <span class="error text-danger" for="input-name">{{$errors->first('contacto')}}</span>
                  @endif
                </div>

            </div>    
        </div>
      </div>  
    </div>     

  <a href="/clientes" class="btn btn-secondary" tabindex="5" style="float: left;"><i class="fas fa-backward"></i></a>
  <button style="float: right;" type="submit" class="btn btn-success" tabindex="6"><i class="fas fa-check"></i></button>
</form>

@endsection

@section('js')   
    <script> 
$('.crearClt').submit(function(e){
            e.preventDefault();
          Swal.fire({
                title: '¿Deseas crear este cliente?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })}
        );

</script>
@endsection