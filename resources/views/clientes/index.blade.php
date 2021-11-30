@extends('layouts.plantillabase')

@section('css')

<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
@endsection

@section('contenido')
@section('title', 'Clientes')
<!DOCTYPE html>
<html>
<head>
<h1 class="bg text-dark text-center pt-2">Gestión de clientes</h1>


<body>


<table id="clientes" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
<a href="clientes/create" class="btn btn-primary mb-3" ><i class="fas fa-plus"></i></a>     
<thead class="bg-primary text-white">
            <tr>
                
                <th scope="col">Nombre</th>
                <th scope="col">Cedula</th>
                <th scope="col">Direccion</th>
                <th scope="col">Contacto</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
          
          <tbody>
              @foreach ($clientes as $cliente)
              <tr>
                 
                  <td>{{$cliente->nombre}}</td>
                  <td>{{$cliente->cedula}}</td>
                  <td>{{$cliente->direccion}}</td>
                  <td>{{$cliente->contacto}}</td>
                  
                  <td id="resp{{ $cliente->id }}">
                      @if($cliente->estado == 1)
                      <a>Activo</a>
                          @else
                      <a>Inactivo</a>
                      @endif
                   </td>
                   <td>
                     
                      
                                            
                      
                      @if($cliente->estado == 0)
                        <a  onclick= "return confirmarDesactivar({{$cliente->estado}},{{$cliente->id}},event)" href="{{ route('clientes.cambioEstadoCliente',$cliente) }}" type="button" class="btn btn-sm btn-danger d-inline formulario-desactivar">Activar</a>
                        @elseif($cliente->estado == 1) 
                        <a  onclick= "return confirmarDesactivar({{$cliente->estado}},{{$cliente->id}},event)" href="{{ route('clientes.cambioEstadoCliente',$cliente) }}" type="button" class="btn btn-sm btn-primary d-inline formulario-activar">Desactivar</a>
                        @endif
                        <a href="/clientes/{{$cliente->id}}/edit" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a> 
                      <a href="/clientes/{{$cliente->id}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>       
                            @csrf
                            
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

<script type="text/javascript">
  $(document).ready(function() {
    tablaClientes= $('#clientes').DataTable({ 
        "lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
    
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
    


$('.mi_checkbox').change(function() {
    //Verifico el estado del checkbox, si esta seleccionado sera igual a 1 de lo contrario sera igual a 0
    var estado = $(this).prop('checked') == true ? 1 : 0; 
    var id = $(this).data('id'); 
        console.log(estado);

    $.ajax({
        type: "GET",
        dataType: "json",
        //url: '/StatusNoticia',
        url: '{{ route('camStado') }}',
        data: {'estado': estado, 'id': id},
        success: function(data){
            $('#resp' + id).html(data.var); 
            console.log(data.var)
         
          }
    });
})
      
});

tablaUsuarios = $('#tablaUsuarios').DataTable({  
    "ajax":{            
        "url": "bd/crud.php", 
        "method": 'POST', //usamos el metodo POST
        "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
        "dataSrc":""
    },
    "columns":[
        {"data": "user_id"},
        {"data": "username"},
        {"data": "first_name"},
        {"data": "last_name"},
        {"data": "gender"},
        {"data": "password"},
        {"data": "status"},
        {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
    ]
});     
      
 

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
                                    url: 'cambioEstadoCliente/clientes/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)
                                    
                                
                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Cliente Desactivado!',
                                '',
                                'success'
                                );
                                window.location.href="/clientes";


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
                                    url: 'cambioEstadoCliente/clientes/'+id,
                                    data: {'estado': estado, 'id': id},
                                    success: function(data){
                                        $('#resp' + id).html(data.var); 
                                        console.log(data.var)

                                    
                                    }
                                    
                                });
                        
                              Swal.fire(
                                '¡Cliente Activado!',
                                '',
                                'success'
                                );
                                window.location.href="/clientes";


                        }
                    })
                    }  


    

                }
</script>



</body>
</html> 
@endsection
@endsection