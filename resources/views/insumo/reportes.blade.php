@extends('layouts.plantillabase')

@section('css')
<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')
@section('title', 'Reporte')

<!DOCTYPE html>
<html>
<head>


<body>
<form action="{{ route('reportes')}}" method ="POST" >              
 @csrf
<h1 class="bg text-dark text-center mt">Reportes de  insumos</h1>


<a href="/insumos"  class="btn btn-secondary mb-3"><i class="fas fa-backward"></i></a>


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
<div class="card-header">
<div class="card-body">

                   <div class="row mt-3">  
                   <div class="col-lg-6">                                                
                    <h4>Top 5 Insumos con mas stock </h4>
                    <canvas id="myChart" width="300" height="300"></canvas>
                    </div>
                    <div class="col-lg-6">             
                    <h4>Top 5 Insumos con menos stock</h4>
                    <canvas id="myChart2" width="300" height="300"></canvas>
                    </div>
              </div>
                    <div class="">
                    <br><br>
                    <center><h1>Todos los insumos</h1></center>
                    <canvas id="myChart3" width="300" height="300"></canvas>
                    </div>

</div>
</div>
</form>




@section('js')

<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>


       

<script type="text/javascript" >
                    var insumos=[];
                    var valores=[];
                    var insumos2=[];
                    var valores2=[];
                    var insumos3=[];
                    var valores3=[];


                $( document ).ready(function() {
                    
                            $.ajax({
                                    url: '/reportes/all',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos.push(arreglo[x].nombre_insumo);
                                        valores.push(arreglo[x].cantidad);

                                    }
                                    generarGrafica();
                                    });

                                    $.ajax({
                                    url: '/reportes/all2',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos2.push(arreglo[x].nombre_insumo);
                                        valores2.push(arreglo[x].cantidad);

                                    }
                                    generarGrafica2();
                                    });

                                    $.ajax({
                                    url: '/reportes/all3',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos3.push(arreglo[x].nombre_insumo);
                                        valores3.push(arreglo[x].cantidad);

                                    }
                                    generarGrafica3();
                                    });
                            

                });

                function generarGrafica(){
                                    const ctx = document.getElementById('myChart').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: insumos,
                                            datasets: [{
                                                label: 'Cantidad de insumos en el inventario',
                                                data: valores,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                    }
                    
                    function generarGrafica2(){
                    const ctx = document.getElementById('myChart2').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: insumos2,
                                            datasets: [{
                                                label: 'Cantidad de insumos en el inventario',
                                                data: valores2,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                    }

                    function generarGrafica3(){
                    const ctx = document.getElementById('myChart3').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: insumos3,
                                            datasets: [{
                                                label: 'Cantidad de insumos en el inventario',
                                                data: valores3,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                    }

        </script>

</body>
</html> 
@endsection
@endsection
                