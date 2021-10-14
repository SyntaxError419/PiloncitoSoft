@extends('layouts.plantillabase')

@section('contenido')

<h2 class="mt-2">Ver pedido</h2>

<div class="card mt-4">
    <div class="card-header mb-2">
            <h5>Información del pedido</h5>
        </div>
        
        <div>
            
            <div class="card-body">
            
            <div class="card mt">
                <div class="card-header mb-2">
                    <h5>Detalle del cliente</h5>
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        
                        <div class="mb-3">
                            
                            <label for="" class="form-label">Nombre:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->nombre}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Dirección:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->direccion}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Contacto:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->contacto}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
    <div class="card-header mb-2">
            <h5>Detalle del pedido</h5>
        </div>
        <div class="card-body">
            <table class="table bg-gray table-bordered table-striped shadow-lg mb-4" style="border-radius: 7px;">
                <thead>
                    <tr>
                        <th>Nombre producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table bg-white">
                @foreach ($ventas->productos as $producto)
                <tr>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$detalleventas->get()->where('id_producto',$producto->id)->first()->cantidad}}</td>
                    <td>{{$detalleventas->get()->where('id_producto',$producto->id)->first()->precio_unitario}}</td>
                    <td>{{$detalleventas->get()->where('id_producto',$producto->id)->first()->precio_total}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
<div>
    <div>
    <div id="divT" class="mr-2" style="float: rigth;">
        <h3></h3>
        <h3>Total: ${{$ventas->total}}</h3>
    </div>  
</div>

<div>
    <label for="" class="form-label"></label>
    @if($ventas->pago == 0)
        <label>Pedido no pago</label>
    @else
        <label>Pedido pago</label>
    @endif
    <br>
    <label for="" class="form-label">Estado:</label>
    @if($ventas->estado == 0)
        <label>Por iniciar</label>
    @elseif($ventas->estado == 1)
        <label>En proceso</label>
    @elseif($ventas->estado == 2)
        <label>Por entregar</label>
    @elseif($ventas->estado == 3)
        <label>En entrega</label>
    @else
        <label>Entregado</label>
    @endif
</div>
</div>
</div>
</div>
<a href="/pedidos" class="btn btn-secondary"><i class="fas fa-backward"></i></a> 
</div>
</div>
</div>
</div>
</div>


<style type="text/css">
#divT {
	float: right;
}
</style>
@endsection