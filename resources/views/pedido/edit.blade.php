@extends('layouts.plantillabase')

@section('contenido')

<h2 class="mt-2">Editar pedido</h2>


<form action="/pedidos/{{$ventas->id}}" method="POST">
@csrf   
@method('PUT')

<div class="mb-3">
    <label for="" class="form-label">Cliente:</label>
    <input list="id_cliente" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->nombre}}">
    <datalist id="id_cliente">
        @foreach($clientes as $c)
        <option value="{{ $c->cedula }}">{{ $c->nombre }}</option>
        @endforeach
    </datalist>
    <input  type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
</div>


        @foreach ($ventas->productos as $producto)
                
            <div class="mb-3">
                <label for="" class="form-label">Nombre producto:</label>
                    <input id="nombre_producto" name="nombre_producto[]" type="text"   class="form-control" value="{{$producto->nombre}} "disabled="true">                   
                    <input  type="hidden"  id="id_producto" name="id_producto[]"   class="form-control" value="{{$producto->id}}">  
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Cantidad:</label>
                    <input id="cantidad" name="cantidad[]" type="text" class="form-control" value="{{$detalleventas->get()->where('id_producto',$producto->id)->first()->cantidad}}">
                </div>

        @endforeach

<div class="mb-3">
    <label for="" class="form-label">Total de la venta:</label>
    <input id="totalventa" name="totalventa" type="number" step="any"  class="form-control" disabled="true" value="{{$ventas->total}}">  
</div>

<div class="mb-3">
    <label for="" class="form-label">Pago realizado:</label>
    @if($ventas->pago == 0)
        <label>No</label>
    @else
        <label>Si</label>
    @endif
     
</div>


<a href="/pedidos" class="btn btn-secondary" >Cancelar</a>
<button type="submit" class="btn btn-primary" >Guardar</button>

</form>

@endsection