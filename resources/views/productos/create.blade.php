@extends('layouts.plantillabase')
@section('contenido')
@section('title', 'Producto')
<style type="text/css">
h1 {text-align: center}
h2 {text-align: left}
h4 {display: inline}
h3, h4 {text-align: right}
.lcd{text-align: right}
</style>
<h2 class="pt-3">Crear producto</h2>
    <div class="card-body">
        <div class="card">
        <form action="{{route ('guardarproducto')}}" method ="POST" class="crearPdt" >
            @csrf
            <div class="card-header">
            <p class="text-danger">Campo obligatorio (*).</p>
                <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Nombre</label><label class="text-danger"> *</label>
                            <input id="nombre" name="nombre" class="form-control" value="{{ old('nombre')}}" tabindex="1" lang="es">
                            @if($errors->has('nombre'))
                                <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="" class="form-label">Precio</label><label class="text-danger"> *</label>
                            <input id="precio" name="precio" type="number" value="{{ old('precio')}}" onkeypress="return event.charCode>= 48 && event.charCode <=57" step="any" class="form-control" tabindex="2" >
                            @if($errors->has('precio'))
                                <span class="error text-danger" for="input-name">{{$errors->first('precio')}}</span>
                            @endif
                        </div>
                </div>

                <div class="row mb-3">
                        <div class="col">
                        <label for="" class="form-label" class="crearPdt">Insumo</label>
                            <select name="id_insumo" class="id_insumo form-control" value=" " tabindex="3" id="id_insumo" lang="es">
                                <option></option>
                                @foreach($insumos as $i)
                                <option value="{{ $i->id }}">{{ $i->nombre_insumo }}</option>
                                @endforeach
                            </select>
                            
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control"  tabindex="4" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad">
                        
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
                    <a href="/productos" class="btn btn-secondary" tabindex="6">Cancelar</a>
                    <button style="float: right;" type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                    </div>
    </form>
@endsection

@section('js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
    @if(session('malpedido') == 'Debes asociar minimo un insumo correctamente.')
    <script>
        Swal.fire(
        '¡Ups!',
        'Debes asociar minimo un insumo correctamente.',
        'warning'
        )
    </script>
    @endif

    

    
   
     <script>
    function resetform() {
            $("form select #id_insumo").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        }
        
        let arrayInsumos = [];
        let objInsumo = {};
        
        
        
        $(document).ready(function(){
            
            $('.id_insumo').select2({
            placeholder: "Seleccione Insumo"
        });
        
        $('.crearPdt').submit(function(e){
            let prducto = " ";
            let nombre = $('#nombre').val();
            console.log(nombre);
            $.ajax({
                        type: "GET",
                        async : false,
                        url: '{{ route('nombrerepetido') }}',
                        data: {'nombre': nombre},
                        success: function(response){
                            prducto = (response);
                        }
                       
                        
                    });

                    console.log(prducto);   
                    e.preventDefault();

                    if ($('#nombre').val() == "" || $('#precio').val() == "" || (arrayInsumos.length) < 1 ) {
                    e.preventDefault();
                    Swal.fire(
                        '¡Ups!',
                        'Realiza el registro correctamente.',
                        'warning'
                        )
                }  
                e.preventDefault();           
                 if ($('#nombre').val() != "" && $('#precio').val() != "" && (arrayInsumos.length) > 0 ) {
                            
                    e.preventDefault();
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
                    if (result.isConfirmed ) {
                        this.submit();
                    }
                    
                    })
                        
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