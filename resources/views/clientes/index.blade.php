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
                     
                      
                                            
                      <a href="/clientes/{{$cliente->id}}/edit" class="btn btn-sm btn-primary" data-id="{{ $cliente->id }},{{ $cliente->estado }}"><i class="fas fa-pen"></i></a> 
                      @if($cliente->estado == 0)
                        <a  onclick= "return confirmarDesactivar({{$cliente->estado}},{{$cliente->id}},event)" href="{{ route('clientes.cambioEstadoCliente',$cliente) }}" type="button" class="btn btn-sm btn-danger d-inline formulario-desactivar"  >Desactivado</a>
                        @elseif($cliente->estado == 1) 
                        <a  onclick= "return confirmarDesactivar({{$cliente->estado}},{{$cliente->id}},event)" href="{{ route('clientes.cambioEstadoCliente',$cliente) }}" type="button" class="btn btn-sm btn-primary d-inline formulario-activar">Activado</a>
                        @endif
                      <a href="/clientes/{{$cliente->id}}/show" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>       
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

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#formUsuarios').submit(function(e){                         
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    username = $.trim($('#username').val());    
    first_name = $.trim($('#first_name').val());
    last_name = $.trim($('#last_name').val());    
    gender = $.trim($('#gender').val());    
    password = $.trim($('#password').val());
    status = $.trim($('#status').val());                            
        $.ajax({
          url: "bd/crud.php",
          type: "POST",
          datatype:"json",    
          data:  {user_id:user_id, username:username, first_name:first_name, last_name:last_name, gender:gender, password:password ,status:status ,opcion:opcion},    
          success: function(data) {
            tablaUsuarios.ajax.reload(null, false);
           }
        });			        
    $('#modalCRUD').modal('hide');											     			
});
        
 

//para limpiar los campos antes de dar de Alta una Persona
$("#btnNuevo").click(function(){
    opcion = 1; //alta           
    user_id=null;
    $("#formUsuarios").trigger("reset");
    $(".modal-header").css( "background-color", "#17a2b8");
    $(".modal-header").css( "color", "white" );
    $(".modal-title").text("Alta de Usuario");
    $('#modalCRUD').modal('show');	    
});

//Editar        
$(document).on("click", ".btnEditar", function(){		        
    opcion = 2;//editar
    fila = $(this).closest("tr");	        
    user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    username = fila.find('td:eq(1)').text();
    first_name = fila.find('td:eq(2)').text();
    last_name = fila.find('td:eq(3)').text();
    gender = fila.find('td:eq(4)').text();
    password = fila.find('td:eq(5)').text();
    status = fila.find('td:eq(6)').text();
    $("#username").val(username);
    $("#first_name").val(first_name);
    $("#last_name").val(last_name);
    $("#gender").val(gender);
    $("#password").val(password);
    $("#status").val(status);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white" );
    $(".modal-title").text("Editar Usuario");		
    $('#modalCRUD').modal('show');		   
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