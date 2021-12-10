@extends('layouts.plantillabase')

@section('css')
<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')


<!DOCTYPE html>
<html>
<head>
<div class="pt-3"></div>
@csrf
<body>
     
 @csrf
<h1 class="bg text-dark text-center pt-3">PiloncitoSoft</h1>


    <div class="pt-4"></div>


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
        <center><h4>Top 5 productos más vendidos</h4></center>
        <canvas id="myChart" width="300" height="300"></canvas>
        </div>

        <div class="col-lg-6">
        <center><h4>Top 5 productos menos vendidos</h4></center>
        <canvas id="myChart2" width="300" height="300"></canvas>
        </div>

        </div>

        <div class="row mt-3">

        <div class="col-lg-6">
        <center><h4>Ventas realizadas vs pedidos cancelados</h4></center>
        <canvas id="myChart3" width="300" height="300"></canvas>
        </div>

        <div class="col-lg-6">
        <center><h4>Ingresos en efectivo vs ingresos en trasnferencia</h4></center>
        <canvas id="myChart4" width="300" height="300"></canvas>
        </div>
        
        </div>

</div>
</div>
<div class="pt-5"></div>


@section('js')

<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

                <script type="text/javascript" >
                    var insumos=[];
                    var valores=[];
                    var insumos2=[];
                    var valores2=[];
                    var insumos3=[];
                    var valores3=[];
                    var insumos4=[];
                    var valores4=[];
                    let desde;
                    let hasta;

                $( document ).ready(function() {

                            $.ajax({
                                    url: '/reportes/allVDash',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                      
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos.push(arreglo[x].nombre);
                                        valores.push(arreglo[x].coun);

                                    }
                                    generarGrafica();
                                    });

                                    $.ajax({
                                    url: '/reportes/allV2Dash',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                            
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos2.push(arreglo[x].nombre);
                                        valores2.push(arreglo[x].coun);

                                    }
                                    generarGrafica2();
                                    });

                                    $.ajax({
                                    url: '/reportes/allV3Dash',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                            
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos3.push(arreglo[x].cancelado);
                                        valores3.push(arreglo[x].pedidos);

                                    }
                                    generarGrafica3();
                                    });

                                    $.ajax({
                                    url: '/reportes/allV4Dash',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                            
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        insumos4.push(arreglo[x].formaPago);
                                        valores4.push(arreglo[x].total);

                                    }
                                    generarGrafica4();
                                    });    

            });

                function generarGrafica(){
                                    const ctx = document.getElementById('myChart').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: insumos,
                                            datasets: [{
                                                label: 'Cantidad de productos vendidos',
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
                                                label: 'Cantidad de productos vendidos',
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
                                            labels: ['Pedidos exitosos','Pedidos cancelados'],
                                            datasets: [{
                                                label: 'Cantidad',
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

                    function generarGrafica4(){
                    const ctx = document.getElementById('myChart4').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: { 
                                            labels: insumos4,
                                            datasets: [{
                                                label: 'Ingresos',
                                                data: valores4,
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
                