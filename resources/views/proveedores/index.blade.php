@extends('layouts.plantillabase')   

@section('css')

<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection


@section('contenido')
@section('title', 'Proveedores')
<script type="text/javascript" >
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
<div id="reloj" text align="right" style="font-size:15px;"></div> 

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
<a href="proveedores/create" onclick="return confirm ('¿Estas seguro que deseas crear un nuevo registro?')"  class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>  <!--Boton crear-->
<br>
   

<table id="proveedores" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
<thead class="bg-primary text-white">


<tr>
    
<!-- <th style=" text-align: center;" scope="col" >Id</th> -->
<th style=" text-align: center;" scope="col">Nit</th>
<th style=" text-align: center;" scope="col">Nombre Contacto</th>
<th style=" text-align: center;" scope="col">Correo</th>
<th style=" text-align: center;" scope="col">Numero Contacto</th>
<th style=" text-align: center;" scope="col">Empresa</th>
<th style=" text-align: center;" scope="col">Direccion Empresa</th>
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
    <td> 
    <form action="{{ route ('proveedores.destroy',$proveedor->id)}}" method="POST">
    <a  href="/proveedores/{{$proveedor->id}}/edit"  class="btn btn-sm btn-primary"  ><i class="fas fa-user-edit"></i></i></a>┇
  
    <a  href="/proveedores/{{$proveedor->id}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>┇
    <!-- @csrf
    @method('DELETE')
    
    <button width="5px;" type="submit" class="btn btn-sm btn-danger" onclick="return confirm ('¿Estas seguro que deseas eliminar este registro?')" ><i class="fas fa-trash"></i>Eliminar</button>  -->
    
</form>

    </td>  
    
    </td>
</tr>

@endforeach
</tbody>

</table>


@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
    $('#proveedores').DataTable();
} );

</script>

@endsection




@endsection