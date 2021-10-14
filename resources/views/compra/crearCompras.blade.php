@extends('layouts.plantillabase')
@section('contenido')
<h2>Crear Compra</h2>

<div class="card">
    
    <div class="card-body">

        <div class="card">
        <form action="{{ route('guardarCompra')}}" method ="POST">      
            <div class="card-header">
            @csrf

            <div class="mb-3">
    <label for="id_proveedor" class="form-label"  required="required" >Proveedor</label>
   
    <select name="id_proveedor" id="id_proveedor"tabindex="1" >
    <option value="">Seleccione un proveedor</option>
    @foreach ($proveedores as $proveedor)
        <option value="{{$proveedor-> id}}" >
        {{$proveedor-> nombrecontacto}}
        </option>
    @endforeach
    </select>
        
<div class="mb-3">
    <label for="" class="form-label">Numero de recibo </label>
    <input id="numReciboCompra" name="numReciboCompra" type="text" class="form-control" tabindex="2" required="required" >  
</div>


    <div class="mb-3">
    <label for="" class="form-label">Fecha</label>
    <input id="fecha" name="fecha" type="datetime-local"   class="form-control" tabindex="3"   required="required" >  
    </div>


   <hr>
    </div>
    <h4>Agregar insumos</h4>
    
                          <div class="form-group">
                            <label for="id_insumo">Insumo:</label>
                                 <select name="id_insumo" id="id_insumo" tabindex="4">
                                     <option value="">Seleccione el insumo</option>
                                      @foreach ($insumos as $insumo)
                                     <option value="{{$insumo ->id }}"> {{$insumo->nombre_insumo}}</option>
                                      @endforeach
                                  </select>
                         </div> 
                 <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="text" class="form-control" name="cantidad" id="cantidad" tabindex="5">
                 </div>

                 <div class="form-group">
                        <label for="cantidad">Iva</label>
                        <input type="text" class="form-control" name="iva" id="iva" tabindex="6">
                 </div>

                 <div class="mb-3">
                    <label for="" class="form-label">Precio Unitario </label>
                    <input id="precio_unitario" name="precio_unitario" type="text" step="any" value="0" class="form-control" tabindex="7" required="required">  
                </div>

                    <hr>
                    <button type="button" id="agregarInsumo" class="btn btn-secondary" tabindex="8">Agregar</button>
        
           
             </div>
                    <div class="card-body">
                    <table class="table bg-gray table-bordered table-striped shadow-lg mb-4" style="border-radius: 7px;">
                        <thead >
                                <tr>
                                    <th >Nombre insumo</th>
                                    <th>Cantidad ingresada</th>
                                    <th>Iva</th>
                                    <th>Precio unitario</th>
                                    <th>SubTotal</th>
                                    <th>Total</th>
                                    <th>Opciones</th>
                                </tr>
                        </thead>
                        <tbody id="cajaDetalle">

                        </tbody>
                        <div class="mb-3">
                          <h4 align="right">Total: $ <Span class="totalcompra"></Span></h4>
                          <input type="hidden" id="totalcompra" name="totalcompra"   >  
                    </div>
                    </table>
                    
                    <hr>
                    
                    </div>      
                    <hr>
                    
                    <a href="/compras" class="btn btn-secondary" tabindex="10">Cancelar</a>
                    <button type="submit" class="btn btn-dark" tabindex="11">Guardar compra</button>
         </form>
        </div>

    </div>

</div>




@endsection
@section('js')
<script >
 
    let arrayid_insumo=[];
    let arrayCantidad=[];
    let arrayIva=[];
    let arrayPrecioUnitario=[];
    let arraySubtotal=[];
    let arrayTotal=[];
    function getTotal(){
            if ($('.precioTotal').length > 0) {
                let totalcompra=0;
                $('.precioTotal').each(function(index){
                    console.log($(this).text());
                    totalcompra += parseInt($(this).text().replace('$',''));
                });             
                $('.totalcompra').text(totalcompra);
                $('#totalcompra').val(totalcompra);
                
            }
            else{
                $('.totalcompra').text(0);
                $('#totalcompra').val(0);
            }
        }
$(document).ready(function(){

$('#agregarInsumo').click(function(){
    let id_insumo = parseInt($('#id_insumo option:selected').val());
    let nombre_insumo = $('#id_insumo option:selected').text();
    let cantidad = parseInt($('#cantidad').val());
    let iva = parseInt($('#iva').val())/100;
    let precio_unitario = parseInt($('#precio_unitario').val());
    let subtotal =cantidad *precio_unitario;
    let precio_total = (subtotal*iva)+subtotal;

    if (arrayid_insumo.includes(id_insumo)) {
        $('#tr-'+id_insumo).remove();
        let indice = arrayid_insumo.indexOf(id_insumo);
        cantidad += arrayCantidad[indice];
        iva = arrayIva[indice];
        precio_unitario = arrayPrecioUnitario[indice];
        subtotal += arraySubtotal[indice];
        precio_total += arrayTotal[indice];

        arrayTotal.splice(1,indice);
        arraySubtotal.splice(1,indice);
        arrayPrecioUnitario.splice(1,indice);
        arrayIva.splice(1,indice);
        arrayCantidad.splice(1,indice);
        arrayid_insumo.splice(1,indice);
        arrayid_insumo.push(id_insumo);
        arrayCantidad.push(cantidad);   
        arrayIva.push(iva);
        arrayPrecioUnitario.push(precio_unitario);
        arraySubtotal.push(subtotal);
        arrayTotal.push(precio_total);

    }else{
        arrayid_insumo.push(id_insumo);
        arrayCantidad.push(cantidad);
        arrayIva.push(iva);
        arrayPrecioUnitario.push(precio_unitario);
        arraySubtotal.push(subtotal);
        arrayTotal.push(precio_total);

        
    }
    console.log(arrayid_insumo);

    $('#cajaDetalle').append(`
     <tr id="tr-${id_insumo}">
            <input type="hidden" name="id_insumo[]" value="${id_insumo}">
            <input type="hidden" name="cantidad[]" value="${cantidad}">
            <input type="hidden" name="iva[]" value="${iva}">
            <input type="hidden" name="precio_unitario[]" value="${precio_unitario}">
            <input type="hidden" name="subtotal[]" value="${subtotal}">
            <input type="hidden" name="precio_total[]" value="${precio_total}">

            <td>${nombre_insumo}</td>
            <td>${cantidad}</td>
            <td>${iva}</td>
            <td>$${precio_unitario}</td>
            <td>$${subtotal}</td>
            <td class="precioTotal">$${precio_total}</td>

            <td>
            
            <button type ="button" class="btn btn-danger" onclick="eliminarInsumo(${id_insumo})">X</button>
            </td>
     </tr>
        `);
        getTotal();



    });

    
});




function eliminarInsumo(id_insumo){
    $('#tr-'+id_insumo).remove();
    console.log(arrayCantidad);
    let indice =arrayid_insumo.indexOf(id_insumo);
  
    console.log(arrayIva);
    console.log(arrayPrecioUnitario);
    console.log(arraySubtotal);
    console.log(arrayTotal);
    arrayCantidad.splice(1, indice);
    arrayid_insumo.splice(1, indice);
    arrayIva.splice(1,indice);
    arrayPrecioUnitario.splice(1,indice);
    arraySubtotal.splice(1,indice);
    arrayTotal.splice(1,indice);
    getTotal();

    

}



</script>



@endsection