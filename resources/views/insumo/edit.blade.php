@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Insumo')


<h2 class="mt-2 ml-3">Editar Insumo</h2>

    <div class="card-body">

         <div class="card">
             <form action="/insumos/{{$insumo->id}}" method="POST"  class="editar">
             <div class="card-header mb-2">

                    @csrf   
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Nombre del insumo </label>
                        <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control"  value="{{$insumo-> nombre_insumo}}" required="required">  
                    </div>


                    <a href="/insumos" class="btn btn-secondary" style="float: left;"><i class="fas fa-backward"></i></a>
                    <button style="float: right;"  type="submit" class="btn btn-success formulario-eliminar"> <i class="fas fa-check"></i></button>

                    </div>
            </form>
</div>


@section('js')

@if(session('error') == 'True')
    <script>
        Swal.fire(
        '¡Oops!',
        'El nombre del insumo ya está registrado, ingresa otro nombre.',
        'error'
        ) 
        
    </script>
@endif

 <script>
     $(document).ready(function(){
    $('.editar').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro de editar este Insumo?',
                    
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, deseo editar el insumo!',
                    cancelButtonText: 'No, deseo volver'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
});
 </script>

@endsection
@endsection