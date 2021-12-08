@extends('layouts.plantillabase')

@section('css')
<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('contenido')
@section('title', 'Reportes')

<!DOCTYPE html>
<html>
<head>


<body>
<form action="{{ route('reporte')}}" method ="POST" >          
 @csrf
<h1 class="bg text-dark text-center mt">Reporte  de Compras</h1>


<a href="/compras"  class="btn btn-secondary mb-3"><i class="fas fa-backward"></i></a>


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
<center><h3 class="m-9">Precio total de cada compra</h3></center>
<div class="card-body">
<div class="row mt-3">
                    <div >
                        <canvas id="myChart" width="300" height="300"></canvas>
                    </div>

        </div>

</div>
</div>
</form>



@section('js')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>


        <script type="text/javascript" >
                    var compras=[];
                    var valores=[];

                $( document ).ready(function() {
                    
                            $.ajax({
                                    url: '/reporte/allC',
                                    method:'POST',
                                    data:{
                                            id:1,
                                            _token:$('input[name="_token"]').val()
                                    }
                                }).done(function(res){
                                    var arreglo = JSON.parse(res);
                                    console.log(arreglo); 
                                    for(var x=0;x<arreglo.length;x++){
                                    
                                        compras.push(arreglo[x].numReciboCompra);
                                        valores.push(arreglo[x].totalcompra);

                                    }
                                    generarGrafica();
                                    });
                            

                });

                function generarGrafica(){
                                    const ctx = document.getElementById('myChart').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: compras,
                                            
                                            datasets: [{
                                                label: 'Total de la compra  ',
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

        </script>

</body>
</html> 
@endsection
@endsection
                