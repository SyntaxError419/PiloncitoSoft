@extends('layouts.plantillabase')   

@section('css')

<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection


@section('contenido')
@section('title', 'Proveedores')
<!-- <script type="text/javascript" >
function startTime(){
today=new Date();
h=today.getHours();
m=today.getMinutes();
s=today.getSeconds();
m=checkTime(m);
s=checkTime(s);
document.getElementById('reloj').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);}
function checkTime(i)
{if (i<10) {i="0" + i;}return i;}
window.onload=function(){startTime();}
</script>
<div id="reloj" text align="right" style="font-size:15px;"></div>  -->

<h1 class="bg text-dark text-center mt">Gestión de Proveedores</h1>


@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{Session::get('success')}}
</div>
@endif
@if ($errors-> any())

@foreach ($errors->all() as $value)
<div class="alert alert-danger" role="alert">   
    {{$value}}
    </div>
@endforeach

@endif



<br>
<a href="proveedores/create"   class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>  <!--Boton crear-->
<br>
   

<table id="proveedores" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
<thead class="bg-primary text-white">


<tr>
    
<!-- <th style=" text-align: center;" scope="col" >Id</th> -->
<th style=" text-align: center;" scope="col">Nit/Cèdula</th>
<th style=" text-align: center;" scope="col">Nombre Contacto</th>
<th style=" text-align: center;" scope="col">Correo C</th>
<th style=" text-align: center;" scope="col">Nùmero Contacto</th>
<th style=" text-align: center;" scope="col">Empresa</th>
<th style=" text-align: center;" scope="col">Direcciòn Empresa</th>
<th style=" text-align: center;" scope="col">Estado</th>
<th style="text-align: center;"scope="col">Acciones</th>
</tr>  

</thead>

<tbody>
@foreach ($proveedores as $proveedor)
<tr>
    <!-- <td style="text-align: center;">{{$proveedor->id}}</td> -->
    <td style="text-align: center;">{{$proveedor->nit}}</td>
    <td style="text-align: center;">{{$proveedor->nombrecontacto}}</td>
    <td style="text-align: center;">{{$proveedor->correocontacto}}</td>
    <td style="text-align: center;">{{$proveedor->numerocontacto}}</td>
    <td style="text-align: center;">{{$proveedor->empresa}}</td>
    <td style="text-align: center;">{{$proveedor->direccionempresa}}</td>
    <td id="resp{{ $proveedor->id }}">
                      @if($proveedor->estado == 1)
                      Activado
                          @else
                     Desactivado
                      @endif
                   </td>
    <td> 
    <!-- <form action="{{ route ('proveedores.destroy',$proveedor->id)}}" method="POST"> -->

    @if($proveedor->estado == 0)
                        <a  onclick= "return confirmarDesactivar({{$proveedor->estado}},{{$proveedor->id}},event)" href="{{ route('proveedores.cambioEstadoProveedor',$proveedor) }}" type="button" class="btn btn-sm btn-danger d-inline formulario-desactivar"  >Desactivado</a>
                        @elseif($proveedor->estado == 1) 
                        <a  onclick= "return confirmarDesactivar({{$proveedor->estado}},{{$proveedor->id}},event)" href="{{ route('proveedores.cambioEstadoProveedor',$proveedor) }}" type="button" class="btn btn-sm btn-primary d-inline formulario-activar">Activado</a>
                        @endif
    
    <a  href="/proveedores/{{$proveedor->id}}/edit"  class="btn btn-sm btn-primary"  ><i class="fas fa-pen"></i></i></a>
  
    <a  href="/proveedores/{{$proveedor->id}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>
</form>

    </td>  
    
    
</tr>

@endforeach
</tbody>
</table>


@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

@if(session('edit') == 'True')
    <script>
        Swal.fire(
        '¡Editado!',
        'El proveedor ha sido editado correctamente.',
        'success'
        ) 
    </script>
@endif

@if(session('guardar') == 'True')
    <script>
        Swal.fire(
        'Guardado!',
        'El proveedor se ha registrado correctamente.',
        'success'
        ) 
    </script>
@endif


<script type="text/javascript">
  $(document).ready(function() {
    tablaProveedores=$('#proveedores').DataTable({ "lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
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

function confirmarDesactivar(estado,id,e){ 
                    e.preventDefault();
                    if (estado) {
                        Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, deseo desactivar el proveedor!',     
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoProveedor/proveedores/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Proveedor Desactivado!',
                                '',
                                'success'
                                );
                                window.location.href="/proveedores";

                        }
                    })
                    }else{
                        Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, deseo activar el proveedor!',     
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoProveedor/proveedores/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                    
                                   }
                                    
                                });
                        
                              Swal.fire(
                                '¡Proveedor activado!',
                                '',
                                'success'
                                );
                                window.location.href="/proveedores";

                        }
                    })
                    }  

                }
    

</script>

@endsection




@endsection