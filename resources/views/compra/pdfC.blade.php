<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{$compras->id }}</title>
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
<h4 class="pt-3" align="center">Número de compra: {{$compras->id}}</h4>

<div class="row mb-3" id="header" id="header">
                            <h4 for="" id="header" class="lb-3">Fecha</h4><br> {{$compras->fecha}}
                        </div>
                        <br>
                        
            <div class="row mb-3" align="center">

                        <div class="row mb-3" id="header">
                            <h4 for="" id="header" class="lb-3">Proveedor:</h4> {{$compras->proveedores->	nombrecontacto}}
                        
                        </div>
                        <div class="row mb-3" id="header">
                            <h4 for="" id="header" class="form-label">Número de recibo:</h4>
                            {{$compras->numReciboCompra}}
                            <br>
                            
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
                        <th>Nombre insumo	</th>
                        <th>Cant.</th>
                        <th>Precio U</th>
                        <th>Iva</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="table bg-white" align="center">
                @php($item=1)
                                      @foreach ($compras->insumos as $insumo)
                                                <tr>
                                                    <td>{{$item}}</td>
                                                    <td>{{$insumo->nombre_insumo}}</td>
                                                    <td>{{$detallecompras->get()->where('id_insumo',$insumo->id)->first()->cantidad}}</td>
                                                    <td>${{number_format($detallecompras->get()->where('id_insumo',$insumo->id)->first()->precio_unitario)}}</td>
                                                    <td>{{($detallecompras->get()->where('id_insumo',$insumo->id)->first()->iva)*100}}%</td>
                                                    <td>${{number_format($detallecompras->get()->where('id_insumo',$insumo->id)->first()->subtotal)}}</td>
                                                    <td>${{number_format($detallecompras->get()->where('id_insumo',$insumo->id)->first()->precio_total)}}</td>
                                                    @php($item++)

                                                </tr>
                                                @endforeach

            </tbody>
        </table>
        <div class="col" id="header" align="center">
            <p><h4 align="right" >TOTAL: ${{number_format($compras-> totalcompra)}}</h4></p></div>
        <div class="col" id="header" align="center">
            <p><h4 for="" class="form-label">REGISTRO DE COMPRA.</h4>
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