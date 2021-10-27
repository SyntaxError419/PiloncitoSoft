@extends('layouts.plantillabase')

@section('contenido')

<h2 class="pt-3">Detalle pedido</h2>

<div class="card mt-4">
    <div class="card-header">
            <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Nombre:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->nombre}}">
                            <input type="hidden" id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Dirección:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->direccion}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Contacto:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->clientes->contacto}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->clientes->id}}">  
                        </div>
                        <div>
                        <div class="row mt-3">
                        <div class="col">
                        <label for="" class="form-label">Estado de pago:</label>
                            @if($ventas->pago == 0)
                                <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="Pago no realizado">
                            @else
                                <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="Pago realizado">
                            @endif
                            
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Estado de pedido:</label>
                            @if($ventas->estado == 0)
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="Por iniciar">
                            @elseif($ventas->estado == 1)
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="En proceso">
                            @elseif($ventas->estado == 2)
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="Por entregar">
                            @elseif($ventas->estado == 3)
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="En entrega">
                            @else
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="Entregado">
                            @endif
                            
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Total:</label>
                            <input disabled="true" id="nombre" name="nombre" type="text" class="form-control" value="{{$ventas->total}}">
                            <input type="hidden"  id="id_cliente" name="id_cliente"   class="form-control" value="{{$ventas->total}}">  
                        </div>
                        </div>
                        </div>
        </div>
        <div>
                        </div>
                    </div>
      
                    <div class="card-body">
            <table class="table bg-gray table-bordered table-striped shadow-lg mb-2" style="border-radius: 7px;">
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