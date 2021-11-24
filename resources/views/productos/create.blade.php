@extends('layouts.plantillabase')
@csrf
@section('contenido')
@section('title', 'Producto')
<style type="text/css">
h1 {text-align: center}
h2 {text-align: left}

h4 {display: inline}
h3, h4 {text-align: right}
.lcd{text-align: right}
</style>
<h2 class="pt-3">Crear Producto</h2>
<form action="{{route ('guardarproducto')}}" method ="POST" class="crearPdt" >
               
    <div class="card-body">
        <div class="card">

            <div class="card-header">
            <span class="error text-danger pt-3">*Campo Obligatorio</span>
                <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Nombre</label>
                            <label for="" class="error text-danger" >*</label>
                            <input id="nombre" name="nombre" class="form-control" value="{{ old('nombre')}}" tabindex="1" lang="es">
                            @if($errors->has('nombre'))
                                <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="" class="form-label">Precio</label>
                            <label for="" class="error text-danger" >*</label>
                            <input id="precio" name="precio" type="number" value="{{ old('precio')}}" onkeypress="return event.charCode>= 48 && event.charCode <=57" step="any" class="form-control" tabindex="2">
                            @if($errors->has('precio'))
                                <span class="error text-danger" for="input-name">{{$errors->first('precio')}}</span>
                            @endif
                        </div>
                </div>

                <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label" class="crearPdt">Insumo</label>
                            
                            <select name="id_insumo" class="id_insumo form-control" value="{{ old('nombre_insumo')}}" tabindex="3" id="id_insumo" lang="es">
                                <option></option>
                                @foreach($insumos as $i)
                                <option value="{{ $i->id }}">{{ $i->nombre_insumo }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('id_insumo'))
                                <span class="error text-danger" for="input-name">{{$errors->first('id_insumo')}}</span>
                            @endif
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" value="{{ old('cantidad')}}" tabindex="4" name="cantidad" id="cantidad">
                                @if($errors->has('cantidad'))
                                <span class="error text-danger" for="input-name">{{$errors->first('cantidad')}}</span>
                            @endif
                            </div>
                        </div>
                        <div>
                            <button type="button" id="agregarInsumo" class="btn btn-secondary mt" style="float: left">Agregar</button>
                        </div>
                    </div>
                </div>    
                    <div class="card-body">
                    <table class=" table-bordered table bg-gray shadow-lg mb-4" style="border-radius: 8px">
                            <thead>
                                <tr>
                                    <th>Nombre producto</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table bg-white table-sm" id="cajaDetalle">
                        
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <div>
                    <a href="/productos" class="btn btn-secondary" tabindex="5" style="float: left;"><i class="fas fa-backward"></i></a>
                    <button style="float: right;" type="submit" class="btn btn-success" tabindex="6"><i class="fas fa-check"></i></button>
                    </div>

    </form>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
    
    @if(session('malpedido') == 'malpedido')
    <script>
        Swal.fire(
        '¡Ups!',
        'Nombre en uso.',
        'warning'
        )
    </script>
    @endif

    @if(session('creadopdtcorrec') == 'creadopdtcorrec.')
    <script>
        Swal.fire(
        '¡Registro exitoso!',
        'exit'
        )
    </script>
    @endif
    <script> 
        

        function resetform() {
            $("form select crearPdt").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        }
        const formatterDolar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0
        });
        let arrayInsumos = [];
        let objInsumo = {};
        

        
        $(document).ready(function(){
            $('.id_insumo').select2({
            placeholder: "Seleccione Insumo"
        });
        
        $('.crearPdt').submit(function(e){
            e.preventDefault();
            
            if ((arrayInsumos.length) > 0 && $('#nombre').val() != "" && $('#precio').val() != "") {
                Swal.fire({
                    title: 'Crear Producto',
                    text: "¿Está seguro de crear éste producto?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            }
            else {
                if ($('#nombre').val() == "" || $('#precio').val() == "") {
                    Swal.fire(
                '¡Ups!',
                'Recuerda llenar los campos obligatorios.',
                'warning'
                )
                }
                else if ((arrayInsumos.length) < 1) {
                    Swal.fire(
                '¡Ups!',
                'Recuerda asociar un insumo como minimo.',
                'warning'
                )
                }

            }               
            });
            $('#agregarInsumo').click(function(){
                if (parseInt($('#cantidad').val()) > 0 &&  parseInt($('#id_insumo option:selected').val()) > -1) {
                    
                    let idInsumo = parseInt($('#id_insumo option:selected').val());
                    let insumo = $('#id_insumo option:selected').text();
                    let cantidad =parseInt($('#cantidad').val());
                    let indexInsumo = getIndexInsumo(idInsumo);

                    resetform();

                    if(indexInsumo > -1){
                        $('#tr-'+idInsumo).remove();
                        objInsumo = arrayInsumos[indexInsumo];
                        objInsumo.cantidad += cantidad;

                    } else {
                        
                        objInsumo = {
                            cantidad, idInsumo,
                        }
                        arrayInsumos.push(objInsumo);
                    }
                   
                    $('#cajaDetalle').append(`
                        <tr id="tr-${objInsumo.idInsumo }">
                            <input type=hidden name="idInsumo[]" value="${ objInsumo.idInsumo }">
                            <input type=hidden name="cantidad[]" value="${ objInsumo.cantidad }">
                            <td>${insumo}</td>
                            <td>${objInsumo.cantidad}</td>
                            
                            <td>
                            <button type="button" class="btn btn-sm btn-danger active"  onclick="eliminarInsumo(${objInsumo.idInsumo })" ><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `);
                    
                }
            });
        });
        function eliminarInsumo(idInsumo) {
            //Borrar el elemento del arreglo
            let index = getIndexInsumo(idInsumo);
            if(index != -1){
                arrayInsumos.splice(index, 1);
                //Borrar la fila del table
                $('#tr-'+idInsumo).remove();
                
            }
        }

        function getIndexInsumo(idInsumo){
            let index = -1;
            if(arrayInsumos.length > 0){
                for(let i = 0; i < arrayInsumos.length; i++){
                    if(arrayInsumos[i].idInsumo == idInsumo){
                        index = i;
                        break;
                    }
                }
            }
            return index;
        }
    </script>
@endsection