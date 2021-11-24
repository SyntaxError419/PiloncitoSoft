@extends('layouts.plantillabase')

@section('contenido')
@section('title', 'Pedido')

<h2 class="pt-3">Editar pedido</h2>


<form action="/pedidos/{{$ventas->id}}" method="POST" class="d-inline formulario-editar">
@csrf   
@method('PUT')

<div class="card mt-4">
    <div class="card-header">
    <p class="text-danger">* Campo obligatorio.</p>
            <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Cliente </label><label class="text-danger"> *</label>
                            <select id="id_cliente" name="id_cliente" class="form-control id_cliente" value="{{$ventas->clientes->cedula}}" required="required" lang="es">
                                <option value="{{$ventas->clientes->cedula}}">{{$ventas->clientes->cedula}}</option>
                                @foreach($clientes as $c)
                                <option value="{{ $c->cedula }}">{{ $c->cedula }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                        <label for="" class="form-label">Pago</label><label class="text-danger">*</label>
                        <select name="pago" id="pago" class="form-control" tabindex="2" required="required">
                            @if($ventas->pago == 0)
                                <option id="nombre" name="nombre" type="text" class="form-control" value="0">Pago no realizado</option>
                                <option id="nombre" name="nombre" type="text" class="form-control" value=1>Pago realizado</option>
                            @else
                                <option id="nombre" name="nombre" type="text" class="form-control" value=1>Pago realizado</option>
                                <option id="nombre" name="nombre" type="text" class="form-control" value="0">Pago no realizado</option>
                            @endif
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Estado de pedido</label><label class="text-danger">*</label>
                            <select name="estado" id="estado" class="form-control" tabindex="3" required="required">
                            @if($ventas->estado == 0)
                            <option value=0>Por iniciar</option>
                            <option value=1>En proceso</option>
                            <option value=2>Por entregar</option>
                            <option value=3>En entrega</option>
                            @elseif($ventas->estado == 1)
                            <option value=1>En proceso</option>
                            <option value=0>Por iniciar</option>
                            <option value=2>Por entregar</option>
                            <option value=3>En entrega</option>
                            @elseif($ventas->estado == 2)
                            <option value=2>Por entregar</option>
                            <option value=0>Por iniciar</option>
                            <option value=1>En proceso</option>
                            <option value=3>En entrega</option>
                            @elseif($ventas->estado == 3)
                            <option value=3>En entrega</option>
                            <option value=0>Por iniciar</option>
                            <option value=1>En proceso</option>
                            <option value=2>Por entregar</option>
                            @endif
                            </select>
                        </div>
                        <div>
                        <div class="row mt-3">

                        <div class="col">
                            <label for="formaPago" class="form-label">Forma de pago</label><label class="text-danger">*</label>
                            <select name="formaPago" id="formaPago" class="form-control" tabindex="4" required="required">
                                @if($ventas->formaPago == "Efectivo")
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia bancaria">Transferencia bancaria</option>
                                @else
                                <option value="Transferencia bancaria">Transferencia bancaria</option>
                                <option value="Efectivo">Efectivo</option>
                                @endif
                            </select>
                        </div>

                        <div class="col">
                            <label for="" class="form-label">Total:</label>
                            <input disabled="true" id="total" name="total" tabindex="5" type="text" class="form-control" value="${{number_format($ventas->total)}}">
                        </div>

                        <div class="col">
                            
                        </div>


                        </div>
                        </div>
        </div>
        <div>
                        </div>
                    </div>
      
                    <div class="card-body">
            <table class="table bg-gray table-bordered table-striped shadow-lg mb-2" style="border-radius: 7px;">
                <thead>
                    <tr>
                        <th>Nombre producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table bg-white">
                @foreach ($ventas->productos as $producto)
                <tr>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$detalleventas->get()->where('id_producto',$producto->id)->first()->cantidad}}</td>
                    <td>${{number_format($detalleventas->get()->where('id_producto',$producto->id)->first()->precio_unitario)}}</td>
                    <td>${{number_format($detalleventas->get()->where('id_producto',$producto->id)->first()->precio_total)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
<div>

</div>
</div>
</div>
<a href="/pedidos" class="btn btn-secondary"><i class="fas fa-backward"></i></a>
<button style="float: right;" type="submit" tabindex="7" class="d-inline formulario-editar btn btn-success"><i class="fas fa-check"></i></button>
</div>
</div>
</div>
</div>
</div>
</form>
@section('js')
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.id_cliente').select2({
            
        });
    });
    </script>
@if(session('editar') == 'El pedido se ha modificado correctamente!')
    <script>
        Swal.fire(
        'Modificado!',
        'El pedido ha sido modificado.',
        'success'
        ) 
    </script>
@endif
@if(session('error') == 'El pedido no se ha podido editar!')
    <script>
        Swal.fire(
        '¡Error!',
        'El pedido no ha sido modificado.',
        'error'
        ) 
    </script>
@endif

<script type="text/javascript">
  $(document).ready(function() {
    $('.formulario-editar').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de modificar el pedido?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, deseo modificar el pedido!',
            cancelButtonText: 'No mofidicar pedido'
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
    });      
});

</script>
@endsection
@endsection
