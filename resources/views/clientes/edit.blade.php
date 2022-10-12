
@extends('layouts.plantillabase')
@section('contenido')
@section('title', 'Mi núcleo familiar')

    <h2 class="pt-3">Editar pariente</h2>
    <div class="card mt-4">
    <div class="card-header">
    <form action="/clientes/{{$cliente->id}}" method="POST" class="crearClt">
    @csrf
    @method('PATCH')
    <span class="error text-danger pt-3">*Campo Obligatorio</span>
        <div class="card-body"> 
        
            <div class="row mb-3"> 

                <div class="col"> 
                  <label for="" class="block font-medium text-sm text-gray-700" >Nombres</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="nombre" name="nombre" type="text" class="form-control" value="{{$cliente->nombre}}" tabindex="1" >
                  @if($errors->has('nombre'))
                    <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                   @endif
                </div>


                <div class="col"> 
                  <label for="" class="block font-medium text-sm text-gray-700" >Apedillos</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="apellidos" name="apellidos" type="text" class="form-control" value="{{$cliente->apellidos}}" tabindex="2" >
                  @if($errors->has('nombre'))
                    <span class="error text-danger" for="input-name">{{$errors->first('apellidos')}}</span>
                   @endif
                </div>
                </div>

                <div class="row mb-3"> 
                <div class="col">
                            <label for="" class="form-label">Tipo de documento</label><label class="text-danger">*</label>
                            <select name="estado" id="estado" class="form-control" tabindex="3" required="required">
                            @if($cliente->tipodocumento == 0)
                            <option value=0>Registro civil</option>
                            <option value=1>Tarjeta de identidad</option>
                            <option value=2>Cédula de ciudadanía</option>
                            @elseif($cliente->estado == 1)
                            <option value=1>Tarjeta de identidad</option>
                            <option value=2>Cédula de ciudadanía</option>
                            @elseif($cliente->estado == 2)
                            <option value=2>Cédula de ciudadanía</option>
                            @endif
                            </select>
                        </div>
  
            
                <div class="col">
                  <label for="" class="block font-medium text-sm text-gray-700">Número de documento</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="numerodocumento" name="numerodocumento" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control" value="{{$cliente->numerodocumento}}" tabindex="2">
                  @if($errors->has('numerodocumento'))
                   <span class="error text-danger" for="input-name">{{$errors->first('numerodocumento')}}</span>
                  @endif
                </div>


            </div> 
            
            
            <div class="row mb-3">
                <div class="col">  
 
                  <label for="" class="block font-medium text-sm text-gray-700">Edad</label>
                  <label for="" class="error text-danger" >*</label>
                  <input list="edad" name="edad" type="text" class="form-control" value="{{$cliente->edad}}" tabindex="3" >
                  @if($errors->has('edad'))
                    <span class="error text-danger" for="input-name">{{$errors->first('edad')}}</span>
                  @endif
                </div>
                <div class="col"> 
                  <label for="" class="form-label">Correo</label>
                  <label for="" class="error text-danger" >*</label>
                  <input list="correo" name="correo" type="text" class="form-control" value="{{$cliente->correo}}" tabindex="4" >
                  @if($errors->has('correo'))
                    <span class="error text-danger" for="input-name">{{$errors->first('correo')}}</span>
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