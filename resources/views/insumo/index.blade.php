@extends('layouts.plantillabase')

@section('css')

<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')
@section('title', 'Insumos')
<!DOCTYPE html>
<html>
<head>

<body>

<h1 class="bg text-dark text-center mt">Gestión de Insumos</h1>

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



<a href="insumos/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>

      
        <table id="insumos" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
          <thead class="bg-primary text-white">
          <tr> 
      <th scope="col">Nombre de insumo</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>


    </tr>
          </thead>
          
          <tbody>
              @foreach ($insumos as $insumo)
              <tr>
                <td>{{$insumo->nombre_insumo}}</td>
                <td>{{$insumo->cantidad}}</td>
                  <td id="resp{{ $insumo->id }}">
                      @if($insumo->estado == 1)
                      Activo
                          @else
                     Inactivo
                      @endif
                   </td>
                   <td> 
                  
               

                      <form action="{{ route('insumos.destroy',$insumo->id) }}" class="d-inline formulario-eliminar"   method="POST">
                      @if($insumo->estado == 0)
                        <a  onclick= "return confirmarDesactivar({{$insumo->estado}},{{$insumo->id}},event)" href="{{ route('insumos.cambioEstadoInsumo',$insumo) }}" type="button" class="btn btn-sm btn-success d-inline formulario-desactivar"  >Activar</a>
                        @elseif($insumo->estado == 1) 
                        <a  onclick= "return confirmarDesactivar({{$insumo->estado}},{{$insumo->id}},event)" href="{{ route('insumos.cambioEstadoInsumo',$insumo) }}" type="button" class="btn btn-sm btn-danger d-inline formulario-activar">Inactivar</a>
                        @endif

                      <a href="/insumos/{{ $insumo->id }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>

                      <a href="/insumos/{{$insumo->id}}/edit" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                     
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>                   
                       </form>                         
                   </td>  
               </tr>
               @endforeach
           </tbody>
      </table>



@section('js')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>

@if(session('edit') == 'True')
    <script>
        Swal.fire(
        '¡Editado!',
        'El insumo ha sido editado correctamente.',
        'success'
        ) 
    </script>
@endif
@if(session('guardar') == 'True')
    <script>
        Swal.fire(
        '¡Creado!',
        'El Insumo ha sido registrado correctamente.',
        'success'
        ) 
    </script>
@endif

@if(session('cancelar') == 'True')
    <script>
        Swal.fire(
        '¡Eliminado!',
        'El Insumo ha sido eliminado.',
        'success'
        ) 
    </script>
@endif  

@if(session('error') == 'True')
    <script>
        Swal.fire(
        '¡Error!',
        'El Insumo no ha sido desactivado.',
        'error'
        ) 
    </script>
@endif

<script type="text/javascript">
  $(document).ready(function() {
    tablaInsumos=$('#insumos').DataTable({ "lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
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
                        title: '¿Estás seguro que deseas eliminar el insumo?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, deseo eliminar el insumo!',
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    })
                });      
                    
                function confirmarDesactivar(estado,id,e){ 
                    e.preventDefault();
                    if (estado) {
                        Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '¡Sí, deseo inactivar el insumo!',     
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoInsumo/insumos/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                    
                                
                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Insumo Inactivado!',
                                '',
                                'success'
                                );
                                window.location.href="/insumos";


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
                        confirmButtonText: '¡Sí, deseo activar el insumo!',     
                        cancelButtonText: 'No,deseo volver '
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoInsumo/insumos/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)

                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Insumo Activado!',
                                '',
                                'success'
                                );
                                window.location.href="/insumos";


                        }
                    })
                    }  


    

                }

</script>

</body>
</html> 
@endsection
@endsection
