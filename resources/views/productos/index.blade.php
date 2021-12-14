@extends('layouts.plantillabase')
@section('css')
<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
@endsection
@section('contenido')
@section('title', 'Productos')
<!DOCTYPE html>
<html>
<head>
<h1 class="bg text-dark text-center pt-2">Gestión Productos</h1>
<body>
<table id="productos" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
<a href="productos/create" class="btn btn-primary mb-3" ><i class="fas fa-plus"></i></a>     
<a  href="https://youtube.com/playlist?list=PLMNr6bGzQSBEuJKzL9CjBqUHg1AJIvr1e" target="_blank" class="btn btn-secondary mb-3 ml-1" style="float: right;">   <i class="fas fa-info" ></i></a> 
<thead class="bg-primary text-white">
            <tr>
               
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
          
          <tbody>
              @foreach ($productos as $producto)
              <tr>
                  
                  <td>{{$producto->nombre}}</td>
                  <td>${{number_format($producto->precio)}}</td>
               
                  <td id="resp{{ $producto->id }}">
                      @if($producto->estado == 1)
                      <a>Activo</a>
                          @else
                      <a>Inactivo</a>
                      @endif
                   </td>
                   <td>
                   <form action="{{ route('productos.destroy',$producto->id) }}" class="d-inline formulario-eliminar" method="POST">

                   @if($producto->estado == 0)
                        <a  onclick= "return confirmarDesactivar({{$producto->estado}},{{$producto->id}},event)" href="{{ route('productos.cambioEstadoProducto',$producto) }}" type="button" class="btn btn-sm btn-success d-inline formulario-desactivar">Activar</a>
                        @elseif($producto->estado == 1) 
                        <a  onclick= "return confirmarDesactivar({{$producto->estado}},{{$producto->id}},event)" href="{{ route('productos.cambioEstadoProducto',$producto) }}" type="button" class="btn btn-sm btn-danger d-inline formulario-activar">Inactivar</a>
                        @endif
                        <a href="/productos/{{ $producto->id }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>

                        @if($producto->estado == 1)
                        <a href="/productos/{{$producto->id}}/edit" class="btn btn-sm btn-primary" data-id="{{ $producto->id }}"><i class="fas fa-pen"></i></a> 
                        @endif
                      
                             
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
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
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

      @if(session('pdtnoelmdo') == 'Realiza el pedido correctamente.')
    <script>
        Swal.fire(
        '¡Ups!',
        'Producto en uso',
        'warning'
        )
    </script>
@endif

@if(session('pdtelmdo') == 'Realiza el pedido correctamente.')
<script>
        Swal.fire(
        '¡Listo!',
        'Producto eliminado.',
        'warning'
        )
    </script>
@endif
@if(session('eliminar') == 'eliminar')
<script>
Swal.fire({
                    title: 'Eliminar Producto',
                    text: "¿Está seguro de eliminar este producto?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No'
                    }).then((result) => {
                    if (result.isConfirmed ) {
                        this.submit();
                    }
                })
</script>
@endif                    
@if(session('creadopdtcorrec') == 'creadopdtcorrec')
    <script>
        Swal.fire(
            '¡Listo!',
            'Producto creado',
            'success'
        )
    </script>
    @endif

    @if(session('modcor') == 'modcor')
    <script>
        Swal.fire(
            '¡Listo!',
            'Producto modificado',
            'success'
        )
    </script>
    @endif
              
         



<script type="text/javascript">
  $(document).ready(function() {
    tablaProductos= $('#productos').DataTable({ 
        "lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]], "order": [[ 2, "asc" ]],
    
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
        
    },
});
});
    
</script>
<script type="text/javascript">
function confirmarDesactivar(estado,id,e){ 
                    e.preventDefault();
                    if (estado) {
                        Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí',     
                        cancelButtonText: 'No'
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoProducto/productos/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                    
                                
                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Producto Desactivado!',
                                '',
                                'success'
                                );
                                window.location.href="/productos";
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
                        confirmButtonText: 'Sí',     
                        cancelButtonText: 'No'
                        }).then((result) => {
                        if (result.value ==true ) {
                            $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    //url: '/StatusNoticia',
                                    url: 'cambioEstadoProducto/productos/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Producto Activado!',
                                '',
                                'success'
                                );
                                window.location.href="/productos";
                        }
                    })
                    }  
    
                }
</script>

      


</body>
</html> 
@endsection
@endsection
