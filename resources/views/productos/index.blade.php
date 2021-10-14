@extends('layouts.plantillabase')

@section('css')

<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
@endsection

@section('contenido')
<!DOCTYPE html>
<html>
<head>
<h1 class="bg text-dark text-center mt">Gestión de Productos</h1>


<body>


@if(Session::has('success'))
<div class="card">
    <div class="alert alert-success" role="alert">
    {{Session::get('success')}}
    </div>
</div>
@endif
@if ($errors-> any())
<div class="class-card">
@foreach ($errors->all() as $value)
<div class="alert alert-danger" role="alert">   

    {{$value}}
    </div>
@endforeach
</div>
@endif




<table id="productos" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">

<a href="productos/create" class="btn btn-primary mb-3" ><i class="fas fa-plus"></i></a>     
<thead class="bg-primary text-white">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
          
          <tbody>
              @foreach ($productos as $producto)
              <tr>
                  <td>{{$producto->id}}</td>
                  <td>{{$producto->nombre}}</td>
                  <td>{{$producto->precio}}</td>
               
                  <td id="resp{{ $producto->id }}">
                      @if($producto->estado == 1)
                      <a>Activo</a>
                          @else
                      <a>Inactivo</a>
                      @endif
                   </td>
                   <td>
                   <form action="{{ route('productos.destroy',$producto->id) }}" class="d-inline formulario-eliminar" method="POST">
                      
                      <label class="switch">
                          <input data-id="{{ $producto->id }}" class="mi_checkbox" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"   {{ $producto->estado ? 'checked' : '' }}>
                          <span class="slider round"></span>
                      </label>
                      
                      <a href="/productos/{{$producto->id}}/edit" class="btn btn-sm btn-primary" data-id="{{ $producto->id }}"><i class="fas fa-pen"></i></a>        
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

<script type="text/javascript">
  $(document).ready(function() {
    tablaProductos= $('#productos').DataTable({ 
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
        url: '{{ route('camtado') }}',
        data: {'estado': estado, 'id': id},
        success: function(data){
            $('#resp' + id).html(data.var); 
            console.log(data.var)
         
          }
    });
})
      
});
</script>



</body>
</html> 
@endsection
@endsection