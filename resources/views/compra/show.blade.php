@extends('layouts.plantillabase')

@section('contenido')
<div>
<center>
<h2>Ver detalles de una compra</h2>
</center>
</div>

<form action="/compras/{{$compra->id}}" method="POST">
@csrf   
@method('PUT')
<div class="mb-3">
    <label for="" class="form-label">Proveedor</label>
    <input  disabled="true" id="nombre" name="nombre" type="text"   class="form-control" value="{{$compra->proveedores->nombrecontacto}}">  
    <input  type="hidden"  id="id_proveedor" name="id_proveedor"   class="form-control" value="{{$compra->proveedores->id}}">  
</div>


<div class="mb-3">
    <label for="" class="form-label">Numero de recibo </label>
    <input disabled="true" id="numReciboCompra" name="numReciboCompra" type="text" class="form-control"  value="{{$compra->numReciboCompra}}">  
</div>


<div class="mb-3">
    <label for="" class="form-label">Fecha</label>
    <input disabled="true"  id="fecha" name="fecha" type="datetime"   class="form-control" value="{{$compra-> fecha}}" >  
</div>



        <div class="card-body">
            <table class="table bg-gray table-bordered table-striped shadow-lg mb-4" style="border-radius: 7px;">
                <thead>
                    <tr>
                        <th>Nombre insumo</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Iva</th>
                        <th>Subtotal</th>
                        <th>Total</th>

                        
                    </tr>
                </thead>
                <tbody class="table bg-white">
                @foreach ($compra->insumos as $insumo)
                <tr>
                    <td>{{$insumo->nombre_insumo}}</td>
                    <td>{{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->cantidad}}</td>
                    <td>${{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->precio_unitario}}</td>
                    <td>{{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->iva}}</td>
                    <td>${{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->subtotal}}</td>
                    <td>${{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->precio_total}}</td>

                </tr>
                @endforeach
            </tbody>
            <h5>Detalle de la compra</h5>        
            <h4 align="right" >Total Compra: ${{$compra-> totalcompra}}</h4>

        </table>
</div>


<center>
<a href="/compras" class="btn btn-secondary"><i class="fas fa-backward"></i></a>
</center>
</form>



@endsection