<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{$ventas->id_recibo}}</title>
<!-- 
        <link href="{{ public_path('css/app.css') }}" rel="stylesheet" type="text/css">
 -->    
 
    </head>
    <body>
    @csrf
<h2 class="pt-3" align="center">El Piloncito Familiar</h2>
<h4 class="pt-3" align="center">NIT: 15.372.745-9</h4>
<div class="row mb-3" align="center">
                        <div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3"></h4> Cl. 39B #94-143 Local 201 Belencito Terminal
                        </div>
                        <div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3">Teléfono</h4> (300)-000-0000
                        </div>
                        <div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3"></h4> Medellín-Colombia
                        </div>
<h4 class="pt-3" align="center">Pedido: {{$ventas->id_recibo}}</h4>

<div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3">Fecha</h4><br> {{$ventas->fecha}}
                        </div>
                        <br>
                        
            <div class="row mb-3" align="center">
                <div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3">Identificación:</h4> {{$ventas->clientes->cedula}}
                        
                        </div>
                        <div class="row mb-3" id="header">
                            <h4 for="" id="header" class="lb-3">Nombre:</h4> {{$ventas->clientes->nombre}}
                        
                        </div>
                        <div class="row mb-3" id="header">
                            <h4 for="" id="header" class="form-label">Dirección:</h4>
                            {{$ventas->clientes->direccion}}
                            <br>
                            
                        </div>
                        <div class="row mb-3"b  id="header">
                            <h4 for="" id="header" class="form-label">Contacto:</h4>
                            {{$ventas->clientes->contacto}}
                        </div>
                        </div>
                        </div>
                        <div>
                        </div>
                    </div>
                <br>
            <table class="table bg-gray table-bordered table-striped shadow-lg mb-2" style="border-radius: 7px;" align="center">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio U.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table bg-white" align="center">
                @php($item=1)
                @foreach ($ventas->productos as $producto)
                <tr>
                    <td>{{$item}}</td>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$detalleventas->get()->where('id_producto',$producto->id)->first()->cantidad}}</td>
                    <td>${{number_format($detalleventas->get()->where('id_producto',$producto->id)->first()->precio_unitario)}}</td>
                    <td>${{number_format($detalleventas->get()->where('id_producto',$producto->id)->first()->precio_total)}}</td>
                    @php($item++)
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col" id="header" align="center">
            <p><h4 for="" align="center" class="form-label">TOTAL:</h4> ${{number_format($ventas->total)}}</p>
        </div>
        <div class="col" id="header" align="center">
            <p><h4 for="" class="form-label">GRACIAS POR SU COMPRA.</h4>
            <p><h4 for="" class="form-label">VUELVA PRONTO.</h4>
        </div>
        
<div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
<style type="text/css">
#divT {
	float: right;
}
#header h4 { display:inline; }
</style>