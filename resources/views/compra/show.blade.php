@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Compra')
<div class="pt-2">
<h2>Ver detalles de una compra</h2>
</div>

<form action="/compras/{{$compra->id}}" method="POST">
                                 @csrf   
                                @method('PUT')

    <div class="card">
        
                <div class="card-header">
                              
                    <div class=row>
                        <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Proveedor</label>
                                    <input  disabled="true" id="nombre" name="nombre" type="text"   class="form-control" value="{{$compra->proveedores->nombrecontacto}}">  
                                    <input  type="hidden"  id="id_proveedor" name="id_proveedor"   class="form-control" value="{{$compra->proveedores->id}}">  
                                </div>
                        </div>
                        
                        <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Numero de recibo </label>
                                    <input disabled="true" id="numReciboCompra" name="numReciboCompra" type="text" class="form-control"  value="{{$compra->numReciboCompra}}">  
                                </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Fecha</label>
                                    <input disabled="true"  id="fecha" name="fecha" type="datetime"   class="form-control" value="{{$compra-> fecha}}" >  
                                </div>
                        </div>

                         <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Estado</label>

                                    @if ($compra->estado == 1)
                                                    
                                    <input id="estado" name="estado" type="text" step="any"  class="form-control"  value="Activado" disabled="true">  
                                    
                                    @else
                                    <input id="estado" name="estado" type="text" step="any"  class="form-control"  value="Inactivo" disabled="true">  
                                    @endif

                                </div>
                        </div>
                        <h5>Detalle de la compra</h5>        

                        </div>
                        </div>

                    

                                <div class="card-body">
                                    <table class=" table-bordered table bg-gray shadow-lg mb-2" style="border-radius: 8px;">
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
                                                <tbody class="table bg-white table-sm">
                                                @foreach ($compra->insumos as $insumo)
                                                <tr>
                                                    <td>{{$insumo->nombre_insumo}}</td>
                                                    <td>{{$detallecompra->get()->where('id_insumo',$insumo->id)->first()->cantidad}}</td>
                                                    <td>${{number_format($detallecompra->get()->where('id_insumo',$insumo->id)->first()->precio_unitario)}}</td>
                                                    <td>{{($detallecompra->get()->where('id_insumo',$insumo->id)->first()->iva)*100}}%</td>
                                                    <td>${{number_format($detallecompra->get()->where('id_insumo',$insumo->id)->first()->subtotal)}}</td>
                                                    <td>${{number_format($detallecompra->get()->where('id_insumo',$insumo->id)->first()->precio_total)}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <h4 align="right" >Total Compra: ${{number_format($compra-> totalcompra)}}</h4>

                                        </table>
                                 </div>
                        </div>
            
                        
       </div>
                  <a href="/compras" class="btn btn-secondary"><i class="fas fa-backward"></i></a>

</div>
</form>

@endsection