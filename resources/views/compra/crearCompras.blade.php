@extends('layouts.plantillabase')
@section('contenido')
@section('title', 'Compra')

<label class="pt-3">
<h2>Crear Compra</h2>
</label>



<div class="card-body">
    <div class="card">
    

    
            
                <form action="{{ route('guardarCompra')}}" method ="POST" class="tomarC">      
                @csrf
                <div class="card-header">
                <p class="text-danger"> Campo obligatorio (*).</p>
                    <div class="row mt-3">
                                <div class="col">
                                                    
                                        <label for="" class="form-label "  >Proveedor </label><label class="text-danger"> *</label>
                                        <select  class="id_proveedor form-control b-4"  name="id_proveedor" id="id_proveedor" tabindex="1"  lang="es" >
                                        <option ></option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{$proveedor-> id}} " >
                                            {{$proveedor-> nombrecontacto}}
                                            </option>
                                        @endforeach
                                        </select>
                                        @if($errors->has('id_proveedor'))
                                        <span class="error text-danger" for="input-name">{{$errors->first('id_proveedor')}}</span>
                                        @endif
                                    </div>
                                <div class="col">
                                        <div class="mb-3 ">
                                        <label for="" class="form-label">Número de recibo  </label><label class="text-danger"> *</label>
                                        <input   onkeypress="return event.charCode>= 48&& event.charCode <=57" id="numReciboCompra" name="numReciboCompra" type="text" class="form-control" tabindex="2"  placeholder="Ingrese el número de recibo"  >
                                        @if($errors->has('numReciboCompra'))
                                        <span class="error text-danger" for="input-name">{{$errors->first('numReciboCompra')}}</span>
                                        @endif
                                        </div>
                                </div>

                                <div class="col">
                                        <label for="" class="form-label">Fecha  </label><label class="text-danger"> *</label>
                                        <input id="fecha" name="fecha" type="datetime-local"  class="form-control" tabindex="3"  >  
                                        @if($errors->has('fecha'))
                                        <span class="error text-danger" for="input-name">{{$errors->first('fecha')}}</span>
                                        @endif
                                </div>
                    </div>

        
                                    <h4>Agregar insumos</h4>
                    <div class="row mb-3">
                            <div class="col-lg-6">
                                    <label for="id_insumo">Insumo  </label>
                                        <select  class="id_insumo form-control" name="id_insumo" id="id_insumo"  tabindex="4" lang="es">
                                            <option></option>
                                            @foreach ($insumos as $insumo)
                                            <option value="{{$insumo ->id }}"> {{$insumo->nombre_insumo}}</option>
                                            @endforeach
                                        </select>                         
                            </div> 
                            <div class="col-lg-6">
                                            <label for="">Cantidad  </label>
                                            <input  onkeypress="return event.charCode>= 48&& event.charCode <=57"  type="text" class="form-control" name="cantidad" id="cantidad"    tabindex="5" placeholder="Ingrese una cantidad mayor a 1">                                   
                            
                            </div> 
                    </div> 
                    <div class="row mb-3">
                    <div class="col-lg-6">

                                            <label for="">Iva</label>
                                            <input  onkeypress="return event.charCode>= 48&& event.charCode <=57"  type="text" class="form-control" name="iva" id="iva"  tabindex="6"  placeholder="Ingrese el porcentaje de iva correspondiente">                  
                            </div>
                            <div class="col-lg-6">
                                        <label for="" class="form-label">Precio Unitario   *</label>
                                        <input   onkeypress="return event.charCode>= 48&& event.charCode <=57" id="precio_unitario" name="precio_unitario" type="text" step="any" class="form-control" tabindex="7"  placeholder="Ingrese un precio unitario mayor a 1">                                 
                                </div>
                    </div>
                                <button type="button" id="agregarInsumo" class="btn btn-secondary" tabindex="8">Agregar</button>

                
                                </div> 

                    
                            <div class="card-body">
                            <table class=" table-bordered table bg-gray shadow-lg mb-2" style="border-radius: 8px;">
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
                                <tbody class="table bg-white table-sm"  id="cajaDetalle">

                                </tbody>
                                <div class="mb-3">
                                <h4 align="right">Total:  <Span class="totalcompra"></Span></h4>
                                <input type="hidden" id="totalcompra" name="totalcompra"   >  
                                </div>
                                </table>    
                            
                            
                        </div>      
                          
            
        </div>
                            <div>
                            <a href="/compras" class="btn btn-secondary" tabindex="10" style="float: left;"><i class="fas fa-backward"></i></a>
                            <button style="float: right;" type="submit" class="btn btn-success" tabindex="11"><i class="fas fa-check"></i></button>
                            </div>
</form>





@section('js')

@if(session('error') == 'True')
    <script>
        Swal.fire(
        '¡Cancelado!',
        'La compra se ha egistrado correctamente.',
        'success'
        ) 
    </script>
@endif
@if(session('errorregistro') == 'errorregistro')
    <script>
        Swal.fire(
        '¡Oops!',
        'el número de factura ya está registrado',
        'error'
        ) 
    </script>
@endif

<script>
        function resetform() {
/*             $('#id_insumo').each(function() { this.selectedIndex = 0 });
 */         $("#cantidad[type=text]").each(function() { this.value = '' });
            $("#iva[type=text]").each(function() { this.value = '' });
            $("#precio_unitario[type=text]").each(function() { this.value = '' });
        }

      const formatterDolar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0
        });

 
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
                $('.totalcompra').text(formatterDolar.format(totalcompra));
                $('#totalcompra').val(totalcompra);
                
            }
            else{
                $('.totalcompra').text(0);
                $('#totalcompra').val(0);
            }
        }
$(document).ready(function(){


$('.tomarC').submit(function(e){
                e.preventDefault();
                if ($('#id_proveedor option:selected').val() == "" &&  $('#numReciboCompra').val() == "" && $('#id_insumo option:selected').val() == "") {
                Swal.fire(
                '¡Ups!',
                'Realiza la compra correctamente agregando un proveedor, un numero de recibo y un insumo a la lista.',
                'warning'
                )
            }  else if ($('#numReciboCompra').val() == "" ) {
                Swal.fire(
                '¡Ups, Ingresa  un número de recibo!',
                'Realiza la compra correctamente ingresando un número de recibo.',
                'warning'
                )
            } 
              else if ($('#fecha').val() == "" ) {
                Swal.fire(
                '¡Ups, Ingresa  una fecha!',
                'Realiza la compra correctamente ingresando una fecha.',
                'warning'
                )
            }  
               else if ($('#id_proveedor option:selected').val() == "" ) {
                Swal.fire(
                '¡Ups, Selecciona un proveedor de la lista!',
                'Realiza la compra correctamente agregando un proveedor a la lista.',
                'warning'
                )
            }
              else if ($('#id_insumo option:selected').val() == "" ) {
                Swal.fire(
                '¡Ups, selecciona un insumo de la lista!',
                'Realiza la compra nuevamente agregando un insumo a la lista.',
                'warning'
                )
            }    else if ((arrayid_insumo.length) < 1) {
                Swal.fire(
                '¡Ups, agrega insumos a la  compra!',
                'Realiza la compra nuevamente agregando insumos  a la compra.',
                'warning'
                )
            }  else{

                Swal.fire({
                    title: '¿Estás seguro de crear esta compra?',
                    text: "¡No podrás revertir éste cambio!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, deseo crear la compra!',
                    cancelButtonText: 'No crear la compra'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })}
            });

$('#agregarInsumo').click(function(){
    if (parseInt($('#cantidad').val()) > 0 && parseInt($('#precio_unitario').val()) > 0 &&  parseInt($('#id_insumo option:selected').val()) > -1) {

    let id_insumo = parseInt($('#id_insumo option:selected').val());
    let nombre_insumo = $('#id_insumo option:selected').text();
    let cantidad = parseInt($('#cantidad').val());
    let iva = parseInt($('#iva').val())/100;
    let precio_unitario = parseInt($('#precio_unitario').val());
    let subtotal =cantidad *precio_unitario;
    let precio_total = (subtotal*iva)+subtotal;
    resetform();

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
            <input type="hidden" class="actualizar-${id_insumo}" name="subtotal[]" value="${subtotal}">
            <input type="hidden" class="actualizar-${id_insumo}" name="precio_total[]" value="${precio_total}">
            <input type="hidden" class="actualizar-${id_insumo}" name="cantidad[]" value="${cantidad}"> 
            <input type="hidden" class="actualizar-${id_insumo}" name="iva[]" value="${iva}">
            <input type="hidden" class="actualizar-${id_insumo}" name="precio_unitario[]" value="${precio_unitario}">
        
            <td>${nombre_insumo}</td>
            <td><input class="editar-${id_insumo}" type="number" disabled name="cantidad[]" value="${cantidad}"> </td>
            <td><input class="editar-${id_insumo}" type="number" disabled name="iva[]" value="${iva*100}"></td>
            <td><input class="editar-${id_insumo}" type="number" disabled name="precio_unitario[]" value="${precio_unitario}"></td>
            <td id="subtotal-${id_insumo}">${formatterDolar.format(subtotal)}</td>
            <td id="total-${id_insumo}">${formatterDolar.format(precio_total)}</td>
            <td style="display:none;"class="precioTotal">$${precio_total}</td>
 
            <td>
            <button type ="button" class="btn btn-primary active edit-${id_insumo}"  onclick= "return confirmarEditar(${id_insumo})"><i class="fas fa-pen"></i></button>
            <button type ="button" class="btn btn-danger active edit-${id_insumo}"  onclick= "return eliminarInsumo(${id_insumo})"><i class="fas fa-trash"></i></button>
            <button type ="button" class="btn btn-success active guardar-${id_insumo}" style="display:none;"  onclick= "return confirmarEditar(${id_insumo})"><i class="fas fa-check"></i></button>
            </td>
     </tr>
        `);
        getTotal();

    }

    });

    
});



function confirmarEditar(e)
{
     var respuesta= true;
                    
     if (respuesta == true) {
            if($(".editar-"+e).prop("disabled"))
            {
                console.log(e);
                $(".editar-"+e).removeAttr("disabled");
                $(".guardar-"+e).show();       
                $(".edit-"+e).hide();       

            }else{
                $(".editar-"+e).attr("disabled",true);
                $(".guardar-"+e).hide();       
                $(".edit-"+e).show();      
                actualizarSubtotal(e); 
                getTotal();

            }
        
         return true;

     } else
     {
         return false;
     }
}


function eliminarInsumo(id_insumo){ 
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, deseo eliminar el insumo!',     
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.value) {
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
                            
                               
                              Swal.fire(
                                '¡Insumo eliminado!',
                                '',
                                'success'
                                );

                        }
                    })

    

}



function editarInsumo(id_insumo){
    
    $('#tr-'+id_insumo).remove();
    console.log(arrayCantidad);
    let indice =arrayid_insumo.indexOf(id_insumo);
  
    console.log(arrayIva);
    console.log(arrayPrecioUnitario);
    console.log(arraySubtotal);
    console.log(arrayTotal);
    arrayCantidad.splice(1,indice);
    arrayid_insumo.splice(1, indice);
    arrayIva.splice(1,indice);
    arrayPrecioUnitario.splice(1,indice);
    arraySubtotal.splice(1,indice);
    arrayTotal.splice(1,indice);
    getTotal();

    

}

function actualizarSubtotal(id_insumo)
{
    var cantidad = $("[name ='cantidad[]'].editar-"+id_insumo).val();
    var iva = $("[name ='iva[]'].editar-"+id_insumo).val()/100;
    var preciou = $("[name ='precio_unitario[]'].editar-"+id_insumo).val();
    var subtotal = cantidad * preciou;
    var precio_total = (subtotal*iva)+subtotal;

    $("[name ='cantidad[]'].actualizar-"+id_insumo).val(cantidad);
    $("[name ='iva[]'].actualizar-"+id_insumo).val(iva);
    $("[name ='precio_unitario[]'].actualizar-"+id_insumo).val(preciou);
    $("[name ='subtotal[]'].actualizar-"+id_insumo).val(subtotal);
    $("[name ='precio_total[]'].actualizar-"+id_insumo).val(precio_total);
    $("[name ='cantidad[]'].actualizar-"+id_insumo).val(cantidad);
    $("#subtotal-"+id_insumo).text(formatterDolar.format(subtotal));
    $("#total-"+id_insumo).text(formatterDolar.format(precio_total));
/*     $($("#subtotal-"+id_insumo).parent()).children().get(12).text(precio_total);
 */    
    $($("#subtotal-"+id_insumo).parent()).children("td.precioTotal").text(precio_total)
}

            
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#id_proveedor').select2({
    placeholder: "Seleccione el proveedor"
});
});
$(document).ready(function() {
    $('#id_insumo').select2({
    placeholder: "Seleccione un insumo de la lista"
});
});
</script>

@endsection
@endsection
