@extends('layouts.plantillabase')

@section('css')

<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')
@section('title', 'Pedidos')
<!DOCTYPE html>
<html>
<head>

<body>

<h1 class="bg text-dark text-center pt-3">Gestión de pedidos</h1>

<a href="pedidos/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>
<a  href="https://youtube.com/playlist?list=PLMNr6bGzQSBEuJKzL9CjBqUHg1AJIvr1e" target="_blank" class="btn btn-secondary mb-3 ml-1" style="float: right;">   <i class="fas fa-info" ></i></a> 


        <table id="pedidos" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
          <thead class="bg-primary text-white">
            <tr>
                <th scope="col">Id. Recibo</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                <th scope="col">Pago</th>
                <th scope="col">Forma de pago</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
          
          <tbody>
              @foreach ($ventas as $venta)
              <tr>
                  <td>{{$venta->id_recibo}}</td>
                  <td>{{$venta->clientes->nombre}}</td>
                  <td>{{$venta->fecha}}</td>
                  <td>${{number_format($venta->total)}}</td> 
                  <td>
                      @if($venta->pago == 0)
                      <p>No</p>
                      @else
                      <p>Si</p>
                      @endif
                  </td>
                  <td>{{$venta->formaPago}}</td>
                  
                  <td>
                    @if($venta->estado == 0)
                        <a onclick= "return cambioEstado({{$venta->estado}},{{$venta->id}},event)" href="{{ route('pedidos.cambioEstadoPedido',$venta) }}" type="button" class="btn btn-sm btn-primary camEstado">Por iniciar</a>
                    @elseif($venta->estado == 1)
                        <a onclick= "return cambioEstado({{$venta->estado}},{{$venta->id}},event)" href="{{ route('pedidos.cambioEstadoPedido',$venta) }}" type="button" class="btn btn-sm btn-danger camEstado">En proceso</a>
                    @elseif($venta->estado == 2)
                        <a onclick= "return cambioEstado({{$venta->estado}},{{$venta->id}},event)" href="{{ route('pedidos.cambioEstadoPedido',$venta) }}" type="button" class="btn btn-sm btn-warning camEstado">Por entregar</a>
                    @elseif($venta->estado == 3)
                        <p>En entrega</p>
                    @else
                        <p>Entregado</p>
                    @endif
                  </td>

                  <td>
                    <form action="{{ route('pedidos.destroy',$venta->id) }}" class="d-inline formulario-eliminar" method="POST">
                    
                    <a onclick= "return cambioAVenta({{$venta->estado}},{{$venta->id}},{{$venta->pago}},event)" href="{{ route('pedidos.cambioEstadoPago',$venta) }}" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                    
                    <a href="/pedidos/{{$venta->id}}/edit" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                    
                    <a href="/pedidos/{{$venta->id}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>

                    <a href="{{ route('pdf',$venta->id) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-receipt"></i></a>
                          @csrf
                          @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    
                  </td>
               </tr>
               @endforeach
           </tbody>
      </table>
      <div class="pt-4"></div>

@section('js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

@if(session('editar') == 'El pedido se ha modificado correctamente!')
<script>
        Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'El pedido se ha modificado correctamente!',
                showConfirmButton: false,
                timer: 3500
            })
    </script>
@endif
@if(session('cancelar') == 'El pedido se ha cancelado correctamente!')
    <script>
        Swal.fire(
        '¡Cancelado!',
        'El pedido ha sido cancelado.',
        'success'
        )
    </script>
@endif
@if(session('pedidoOk') == 'pedidoOk')
    <script>
    $( document ).ready(function() {
        let id = 0;
        $.ajax({
            type: "GET",
            async : false,
            url: '{{ route('getCodId') }}',
            data: {},
            success: function(response){
                id = (response);
            }
        });
        Swal.fire({
            title: '¡Pedido creado exitosamente!',
            text: "¿Desea imprimir el comprobante?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Imprimir comprobante',
            cancelButtonText: 'Ver más tarde'
            }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('pdf', 'cod') }}";
                url = url.replace('cod', id);
                window.open(url, "_blank");
            }
        })
    });
    </script>
@endif
@if(session('error') == 'El pedido no se ha podido cancelar!')
    <script>
        Swal.fire(
        '¡Ups!',
        'El pedido no ha sido cancelado.',
        'error'
        )
    </script>
@endif
@if(session('noEditar') == 'Este pedido no se puede editar, ya está pago!')
    <script>
        Swal.fire(
        '¡Ups!',
        'Este pedido no se puede editar, ya está pago!',
        'warning'
        )
    </script>
@endif

<script type="text/javascript">
  $(document).ready(function() {
    tablaPedidos=$('#pedidos').DataTable({ "lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]], "order": [[ 2, "asc" ]],
        language:{
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad",
        "collection": "Colección",
        "colvisRestore": "Restaurar visibilidad",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "decimal": ",",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "conditions": {
            "date": {
                "after": "Despues",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "notBetween": "No entre",
                "notEmpty": "No Vacio",
                "not": "Diferente de"
            },
            "number": {
                "between": "Entre",
                "empty": "Vacio",
                "equals": "Igual a",
                "gt": "Mayor a",
                "gte": "Mayor o igual a",
                "lt": "Menor que",
                "lte": "Menor o igual que",
                "notBetween": "No entre",
                "notEmpty": "No vacío",
                "not": "Diferente de"
            },
            "string": {
                "contains": "Contiene",
                "empty": "Vacío",
                "endsWith": "Termina en",
                "equals": "Igual a",
                "notEmpty": "No Vacio",
                "startsWith": "Empieza con",
                "not": "Diferente de"
            },
            "array": {
                "not": "Diferente de",
                "equals": "Igual",
                "empty": "Vacío",
                "contains": "Contiene",
                "notEmpty": "No Vacío",
                "without": "Sin"
            }
        },
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d"
    },
    "select": {
        "cells": {
            "1": "1 celda seleccionada",
            "_": "%d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        },
        "rows": {
            "1": "1 fila seleccionada",
            "_": "%d filas seleccionadas"
        }
    },
    "thousands": ".",
    "datetime": {
        "previous": "Anterior",
        "next": "Proximo",
        "hours": "Horas",
        "minutes": "Minutos",
        "seconds": "Segundos",
        "unknown": "-",
        "amPm": [
            "AM",
            "PM"
        ],
        "months": {
            "0": "Enero",
            "1": "Febrero",
            "10": "Noviembre",
            "11": "Diciembre",
            "2": "Marzo",
            "3": "Abril",
            "4": "Mayo",
            "5": "Junio",
            "6": "Julio",
            "7": "Agosto",
            "8": "Septiembre",
            "9": "Octubre"
        },
        "weekdays": [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sab"
        ]
    },
    "editor": {
        "close": "Cerrar",
        "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
        },
        "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
        },
        "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "_": "¿Está seguro que desea eliminar %d filas?",
                "1": "¿Está seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
        },
        "multi": {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    },
    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros"
} 

    });      
});

$('.formulario-eliminar').submit(function(e){
    e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir éste cambio!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, deseo cancelar el pedido!',
            cancelButtonText: 'No cancelar pedido'
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
        }
    })
});      

</script>
<script type="text/javascript"> 
    function cambioEstado(estado,id,e){ 
        e.preventDefault();
        if (estado) {
            Swal.fire({
            title: '¿Estás seguro de que quieres cambiar el estado del pedido?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, deseo el estado del pedido',     
            cancelButtonText: 'No realizar el cambio'
            }).then((result) => {
            if (result.value ==true ) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'cambioEstadoPedido/pedidos/'+id,
                    data: {'estado': estado, 'id': id},
                    success: function(data){                      
                    }
                });
                window.location.href="/pedidos";
            }
        })
        }else{
            Swal.fire({
            title: '¿Estás seguro de que quieres cambiar el estado del pedido?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, deseo el estado del pedido',     
            cancelButtonText: 'No realizar el cambio'
            }).then((result) => {
            if (result.value ==true ) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'cambioEstadoPedido/pedidos/'+id,
                    data: {'estado': estado, 'id': id},
                    success: function(data){
                    }
                });
                window.location.href="/pedidos";
            }
        })
    }
    
}

</script>
<script type="text/javascript"> 
    function cambioAVenta(estado,id, pago, e){ 
        e.preventDefault();
        if (estado && pago) {
            Swal.fire({
            title: '¿Estás seguro de que éste pedido ha sido pagado y entregado?',
            text: "¡No podrás revertir este cambio jamás!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, el pedido ha sido pagado y entregado',
            cancelButtonText: 'No realizar el cambio'
            }).then((result) => {
            if (result.value ==true ) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'cambioEstadoPago/pedidos/'+id,
                    data: {'estado': estado, 'pago' : pago, 'id': id},
                    success: function(data){
                        $('#resp' + id).html(data.var); 
                        console.log(data.var)                            
                    }
                });
                window.location.href="/pedidos";
            }
        })
        }else{
            Swal.fire({
            title: '¿Estás seguro de que éste pedido ha sido pagado y entregado?',
            text: "¡No podrás revertir este cambio jamás!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, el pedido ha sido pagado y entregado',
            cancelButtonText: 'No realizar el cambio'
            }).then((result) => {
            if (result.value ==true ) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'cambioEstadoPago/pedidos/'+id,
                    data: {'estado': estado, 'pago' : pago, 'id': id},
                    success: function(data){
                        $('#resp' + id).html(data.var); 
                        console.log(data.var)
                    }
                });
                window.location.href="/pedidos";
            }
        })
    }
}
    
</script>
</body>
</html> 
@endsection
@endsection
