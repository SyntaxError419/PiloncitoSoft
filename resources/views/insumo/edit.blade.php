@extends('layouts.plantillabase')

@section('contenido')


<h2 class="mt-2 ml-3">Editar Insumo</h2>

    <div class="card-body">

         <div class="card">
             <form action="/insumos/{{$insumo->id}}" method="POST">
             <div class="card-header mb-2">

                    @csrf   
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Nombre del insumo </label>
                        <input id="nombre_insumo" name="nombre_insumo" type="text" class="form-control"  value="{{$insumo-> nombre_insumo}}" required="required">  
                    </div>


                    <a href="/insumos" class="btn btn-secondary" style="float: left;"><i class="fas fa-backward"></i></a>
                    <button style="float: right;" type="submit" class="btn btn-success" ><i class="fas fa-check"></i></button>

                    </div>
            </form>
</div>



@endsection