@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Pedido')
<style type="text/css">
h1 {text-align: center}
h2 {text-align: left}
h3 {display: inline}
h4 {display: inline}
h3, h4 {text-align: right}
.lcd{text-align: right}
</style>
<label class="pt-3">
<h2>Tomar pedido</h2> 
</label>
    <div class="card-body">
        <div class="card">
            <form id="myForm" action="/pedidos" method ="POST" class="tomarP">
                @csrf
                <div class="card-header">
                    <div class="row">
                    <div class="col">
                        <label for="" class="form-label">Cliente:</label>
                        <select name="id_cliente" class="id_cliente js-states form-control" tabindex="1" required="required" id="id_cliente" lang="es">
                            <option></option>
                            @foreach($clientes as $c)
                            <option value="{{ $c->cedula }}">{{ $c->cedula }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label">Forma de pago:</label>
                        <select name="formaPago" class="form-control" tabindex="2" required="required" id="formaPago" lang="es">
                            <option></option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia bancaria">Transferencia bancaria</option>
                        </select>    
                    </div>
                    </div>
                    <div class="row mt-3">
                    <div class="col">
                        <label for="id_producto" class="form-label">Producto:</label>
                            <select class="form-control" name="id_producto" id="id_producto" tabindex="3" lang="es">
                                <option></option>
                                @foreach($productos as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="cantidad" id="cantidad" tabindex="4" placeholder="Ingrese la cantidad">
                    </div>                    
                    </div>
                    <div class="lcd mt-4">
                    <button type="button" id="agregarProducto" class="btn btn-secondary mt" style="float: left;" tabindex="5">Agregar</button>
                        <h3>Total:</h3>
                        <h3 id="totalVenta"></h3>
                        <input name="totalVentaV" type="hidden" type="number" id="totalVentaV" value=0>
                        <div class="">
                            <label for="1" >Pago realizado</label>
                            <input type="checkbox" id="pago" name="pago" value="1" tabindex="5">
                        </div>                     
                    </div>
                </div>
                    <div class="card-body">
                        <table class=" table-bordered table bg-gray shadow-lg mb-2" style="border-radius: 8px;"">
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
                
@endsection

@section('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>
@if(session('malpedido') == 'Realiza el pedido correctamente.')
    <script>
        Swal.fire(
        '¡Ups!',
        'Realiza el pedido correctamente.',
        'warning'
        )
    </script>
@endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.id_cliente').select2({
            placeholder: "Seleccione el cliente"
        });
        
        $('#id_producto').select2({
            placeholder: "Seleccione el producto"
        });

        $('#formaPago').select2({
            placeholder: "Seleccione la forma de pago"
        });

    });
    </script>
    <script> 
        function resetform() {
            $("form select P").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        }
        const formatterDolar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0
        });

        let arrayProductos = [];
        let objProducto = {};
        function getTotal(){
            let totalVenta=0;
            arrayProductos.forEach(function(objProducto) {
                totalVenta+=(objProducto.subTotal);
            });
            return (totalVenta);
            }
        $(document).ready(function(){
            let stock;
            let cliente;
            $('.tomarP').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro de crear éste pedido?',
                    text: "¡No podrás revertir éste cambio!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, deseo crear el pedido!',
                    cancelButtonText: 'No crear pedido'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
            
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
                    $.ajax({
                        type: "GET",
                        async : false,
                        url: '{{ route('getStock') }}',
                        data: {'idProducto': idProducto, 'cantidad': cantidad},
                        success: function(response){
                            stock = (response);
                        }
                    });

                    if (stock == null || stock == 0) {
                        Swal.fire(
                        '¡No hay insumos suficientes para realizar la cantidad del producto seleccionados!',
                        'Por favor verifica la cantidad de insumos que tienes disponibles.',
                        'warning'
                        )
                    }else{
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
                        $('#totalVenta').text(formatterDolar.format(getTotal()));
                        $('#totalVentaV').val(getTotal());
                        $('#cajaDetalle').append(`
                            <tr id="tr-${objProducto.idProducto }">
                                <input type=hidden name="idProducto[]" value="${ objProducto.idProducto }">
                                <input type=hidden name="cantidad[]" value="${ objProducto.cantidad }">
                                <input type=hidden name="precioUnitario[]" value="${ objProducto.precioUnitario }">
                                <input type=hidden name="subTotal[]" value="${ objProducto.subTotal}">
                                <td>${producto}</td>
                                <td>${objProducto.cantidad}</td>
                                <td>${formatterDolar.format(objProducto.precioUnitario)}</td>
                                <td>${formatterDolar.format(objProducto.subTotal)}</td>
                                <td>
                                    <button type="button" class="btn btn-danger active btn-sm" onclick="eliminarProducto(${objProducto.idProducto})"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `);
                    }
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
                $('#totalVenta').text(formatterDolar.format(getTotal()));
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
@endsection