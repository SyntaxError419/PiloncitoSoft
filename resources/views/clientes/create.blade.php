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
                  <label for="" class="block font-medium text-sm text-gray-700" >Nombres</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre')}}" tabindex="1" >
                  @if($errors->has('nombre'))
                    <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                   @endif
                </div>
  
            
                <div class="col">
                  <label for="" class="block font-medium text-sm text-gray-700">Apellidos</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="apellidos" name="apellidos" type="text" class="form-control" value="{{ old('apellidos')}}" tabindex="2">
                  @if($errors->has('apellidos'))
                   <span class="error text-danger" for="input-name">{{$errors->first('apellidos')}}</span>
                  @endif
                </div>
            </div>


            <div class="row mb-3"> 
                <div class="col"> 
                  <label for="" class="form-label">Tipo de documento</label><label class="text-danger">*</label>
                  <select name="tipodocumento" class="form-control" tabindex="3" id="tipodocumento" lang="es">
                      <option></option>
                      <option value=0 >Registro civil</option>
                      <option value=1 >Tarjeta de identidad</option>
                      <option value=2 >Cédula de ciudadanía</option>
                  </select> 
                  @if($errors->has('tipodocumento'))
                  <span class="error text-danger" for="input-name">{{$errors->first('tipodocumento')}}</span>
                  @endif
                </div>
  
            
                <div class="col">
                  <label for="" class="block font-medium text-sm text-gray-700">Número de documento</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="numerodocumento" name="numerodocumento" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control" value="{{ old('numerodocumento')}}" tabindex="4">
                  @if($errors->has('cedula'))
                   <span class="error text-danger" for="input-name">{{$errors->first('numerodocumento')}}</span>
                  @endif
                </div>
            </div> 
            
            
            <div class="row mb-3">
            <div class="col"> 
                  <label for="" class="form-label">Género</label><label class="text-danger">*</label>
                  <select name="genero" class="form-control" tabindex="5" id="genero" lang="es">
                      <option></option>
                      <option value=0 >Femenino</option>
                      <option value=1 >Masculino</option>
                  </select> 
                  @if($errors->has('genero'))
                  <span class="error text-danger" for="input-name">{{$errors->first('genero')}}</span>
                  @endif
                </div>
                <div class="col">
                  <label for="" class="block font-medium text-sm text-gray-700">Edad</label>
                  <label for="" class="error text-danger" >*</label>
                  <input id="edad" name="edad" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control" value="{{ old('edad')}}" tabindex="6">
                  @if($errors->has('edad'))
                   <span class="error text-danger" for="input-name">{{$errors->first('edad')}}</span>
                  @endif
                </div>

            </div>
            
            <div class="row mb-3">
            <div class="col"> 
                  <label for="" class="block font-medium text-sm text-gray-700" >Correo electrónico</label>
                  <!-- <label for="" class="error text-danger" >*</label> -->
                  <input id="correo" name="correo" type="text" class="form-control" value="{{ old('correo')}}" tabindex="7" >
                  @if($errors->has('correo'))
                    <span class="error text-danger" for="input-name">{{$errors->first('correo')}}</span>
                   @endif
                </div>
                <div class="col"> 
                  <label for="" class="block font-medium text-sm text-gray-700" >Parentesco</label>
                  <!-- <label for="" class="error text-danger" >*</label> -->
                  <input id="parentesco" name="parentesco" type="text" class="form-control" value="{{ old('parentesco')}}" tabindex="8" >
                  @if($errors->has('parentesco'))
                    <span class="error text-danger" for="input-name">{{$errors->first('parentesco')}}</span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

<script> 
$('.crearClt').submit(function(e){
            e.preventDefault();
          Swal.fire({
                title: '¿Deseas agregar un nuevo usuario a tu nucleo familiar?',
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#tipodocumento').select2({
            placeholder: "Seleccione el tipo de documento"
        });

        $('#genero').select2({
            placeholder: "Seleccione el género"
        });
    });

</script>
@endsection