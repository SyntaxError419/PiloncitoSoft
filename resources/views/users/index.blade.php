@extends('layouts.plantillabase')   

@section('css')

<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection


@section('contenido')
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

<h1 class="bg text-dark text-center mt">Gestión de USUARIOS</h1>

<br>
<a href="users/create"  class="btn btn-primary" ><i class="fas fa-plus-square"></i></a>  
<br>
<br>
   

<table id="users" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
<thead class="bg-primary text-white">


<tr>
    
<!-- <th style=" text-align: center;" scope="col" >Id</th> -->
<th style=" text-align: center;" scope="col">Nombre</th>
<th style=" text-align: center;" scope="col">Correo</th>
<th style=" text-align: center;" width="100px" scope="col">Acciones</th>
</tr>  

</thead>

<tbody>
@foreach ($users as $user)
<tr>
    <!-- <td style="text-align: center;">{{$user->id}}</td> -->
    <td style="text-align: center;">{{$user->name}}</td>
    <td style="text-align: center;">{{$user->email}}</td>

    <td> 
    <form action="{{ route ('users.destroy',$user->id)}}" method="POST">
    <a  href="/users/{{$user->id}}/edit"  class="btn btn-sm btn-primary"  onclick="return confirm ('¿Estas seguro que deseas editar este registro?')" ><i class="fas fa-user-edit"></i></i>Editar</a>
  
   
    
    
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
    $('#users').DataTable();
} );

</script>

@endsection




@endsection
