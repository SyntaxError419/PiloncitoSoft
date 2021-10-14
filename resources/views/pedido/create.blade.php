@extends('layouts.plantillabase')

@section('contenido')

<div class="card mt-4">
    <div class="card-header mb-2">
        <h4>Pedido</h4>
    </div>
    <div class="card-body">
        <div class="card">
            <form id="myForm" action="/pedidos" method ="POST">
                @csrf
                <div class="card-header">
                    <div class="form-group">
                        <label for="" class="form-label">Cliente:</label>
                        <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" list="id_cliente" name="id_cliente" placeholder="Seleccione el cliente" class="form-control" tabindex="1" required="required">
                        <datalist id="id_cliente">
                            @foreach($clientes as $c)
                            <option value="{{ $c->cedula }}">{{ $c->nombre }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Forma de pago:</label>
                        <input list="formaPago" name="formaPago" placeholder="Seleccione el método de pago" class="form-control" tabindex="2" required="required">
                        <datalist id="formaPago">
                            <option value="Efectivo">
                            <option value="Transferencia bancaria">
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="id_producto" class="form-label">Producto:</label>
                            <select class="form-control" name="id_producto" id="id_producto" tabindex="3">
                                <option value="">Seleccione el producto</option>
                                @foreach($productos as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                    </div>
                        
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="cantidad" id="cantidad" tabindex="5">
                    </div>                    
                        
                    <div class="lcd mt-2">
                    <button type="button" id="agregarProducto" class="btn btn-secondary mt" style="float: left;" tabindex="5">Agregar</button>
                        <h3>Total: $</h3>
                        <h3 id="totalVenta"></h3>
                        <input name="totalVentaV" type="hidden" type="number" id="totalVentaV" value=0>
                        <div class="">
                            <label for="1" >Pago realizado</label>
                            <input type="checkbox" id="pago" name="pago" value="1" tabindex="5">
                        </div>                     
                    </div>
                </div>
                    <div class="card-body">
                        <table class=" table-bordered table bg-gray shadow-lg mb-4" style="border-radius: 8px;"">
                            <thead>
                                <tr>
                                    <th>Nombre producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table bg-white table-sm" id="cajaDetalle">
                        
                            </tbody>
                        </table>
                    </div>
                </div>
                    <div>
                        <a href="/pedidos" class="btn btn-secondary" tabindex="6" style="float: left;"><i class="fas fa-backward"></i></a>
                        <button style="float: right;" type="submit" class="btn btn-success" tabindex="7"><i class="fas fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
@endsection

@section('js')
    <script> 
        function resetform() {
            $("form select").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        }

        let arrayProductos = [];
        let objProducto = {};
        function getTotal(){
            let totalVenta=0;
            arrayProductos.forEach(function(objProducto) {
                totalVenta+=(objProducto.subTotal);
            });
            return totalVenta;
            }
        $(document).ready(function(){
            
            $('#agregarProducto').click(function(){
                if (parseInt($('#cantidad').val()) > 0 && $('#id_producto option:selected').val() != "") {
                    let precioUnitario;
                    let idProducto = parseInt($('#id_producto option:selected').val());
                    let producto = $('#id_producto option:selected').text();
                    let cantidad =parseInt($('#cantidad').val());
                    resetform();
                    $.ajax({
                        type: "GET",
                        async : false,
                        url: '{{ route('getPrice') }}',
                        data: {'idProducto': idProducto},
                        success: function(response){
                            precioUnitario = (response);
                        }
                    });
                    let subTotal = cantidad*precioUnitario;
                    let indexProducto = getIndexProducto(idProducto);
                    

                    if(indexProducto > -1){
                        $('#tr-'+idProducto).remove();
                        objProducto = arrayProductos[indexProducto];
                        objProducto.cantidad += cantidad;
                        objProducto.precioUnitario = precioUnitario;
                        objProducto.subTotal += subTotal;
                        objProducto.idProducto = idProducto;
                    } else {
                        objProducto = {
                            cantidad, precioUnitario, subTotal, idProducto
                        }
                        arrayProductos.push(objProducto);
                    }
                    $('#totalVenta').text(getTotal());
                    $('#totalVentaV').val(getTotal());
                    $('#cajaDetalle').append(`
                        <tr id="tr-${objProducto.idProducto }">
                            <input type=hidden name="idProducto[]" value="${ objProducto.idProducto }">
                            <input type=hidden name="cantidad[]" value="${ objProducto.cantidad }">
                            <input type=hidden name="precioUnitario[]" value="${ objProducto.precioUnitario }">
                            <input type=hidden name="subTotal[]" value="${ objProducto.subTotal}">
                            <td>${producto}</td>
                            <td>${objProducto.cantidad}</td>
                            <td>$${objProducto.precioUnitario}</td>
                            <td>$${objProducto.subTotal}</td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarProducto(${objProducto.idProducto})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `);
                }
            });
        });
        function eliminarProducto(idProducto) {
            //Borrar el elemento del arreglo
            let index = getIndexProducto(idProducto);
            if(index != -1){
                arrayProductos.splice(index, 1);
                //Borrar la fila del table
                $('#tr-'+idProducto).remove();
                $('#totalVenta').text(getTotal());
                $('#totalVentaV').val(getTotal());
            }
        }

        function getIndexProducto(id){
            let index = -1;
            if(arrayProductos.length > 0){
                for(let i = 0; i < arrayProductos.length; i++){
                    if(arrayProductos[i].idProducto == id){
                        index = i;
                        break;
                    }
                }
            }
            return index;
        }
    </script>
<style type="text/css">
h1 {text-align: center}
h2 {text-align: left}
h3 {display: inline}
h4 {display: inline}
h3, h4 {text-align: right}
.lcd{text-align: right}
</style>
@endsection