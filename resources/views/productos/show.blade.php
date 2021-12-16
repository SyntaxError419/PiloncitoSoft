
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
<h2 class="pt-3">Detalles del producto</h2>
    <div class="card-body">
        <div class="card">
         
            
        <form action="/productos/{{$productos->id}}" method ="POST" class="crearPdt" >
        @method('PUT') 
            @csrf
            <div class="card-header">
                <div class="row mb-3">
                        <div class="col">
                        <input type="hidden" id="idProd" name="idProd" value="{{ $productos->id}}">
                            <label for="" class="form-label">Nombre</label>
                            <input   id="nombre" name="nombre" class="form-control" value="{{$productos->nombre}}" tabindex="1" lang="es" disabled="true">
                            @if($errors->has('nombre'))
                                <span class="error text-danger" for="input-name">{{$errors->first('nombre')}}</span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="" class="form-label">Precio</label>
                            <input id="precio" name="precio" type="number" value="{{$productos->precio}}" onkeypress="return event.charCode>= 48 && event.charCode <=57" step="any" class="form-control" tabindex="2" disabled="true" >
                            @if($errors->has('precio'))
                                <span class="error text-danger" for="input-name">{{$errors->first('precio')}}</span>
                            @endif

                            
                        </div>
                        </div>
                        </div>
                        <div class="card-body">
           <label for="cantidad">Detalle de insumos existentes</label>
           
                    <table class=" table-bordered table bg-gray shadow-lg mb-4" style="border-radius: 8px">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody class="table bg-white table-sm" id="cajaDetallee">
                                <!--DETALLE INSUMOS ASOCIADOS-->
                                @foreach($insumoproductos as $ins)
                                    <tr>
                                        <td>{{ $ins->nombre_insumo }}
                                            <input type="hidden" value="{{ $ins->id }}" />
                                        </td>
                                        <td>{{ $ins->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
           </div>
                    <div>
                    <a href="/productos" class="btn btn-secondary" tabindex="6"><i class="fas fa-backward"></i></a>
                    </div>
                </div>

                
                
        
                        </div>
               
       
                <tbody>
             
           </tbody>

         
         
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
 
@if(session('malpedido') == 'malpedido')
    <script>
        Swal.fire(
        '¡Ups!',
        'Debes asociar minimo un insumo correctamente.',
        'warning'
        )
    </script>
    @endif
   
    @if(session('malinsu') == 'creadopdtcorrec')
    <script>
        Swal.fire(
            '¡Listo!',
            'Producto creado',
            'succes'
        )
    </script>
    @endif 

    @if(session('modcor') == 'modcor')
    <script>
        Swal.fire(
            '¡Listo!',
            'Producto modificado',
            'succes'
        )
    </script> 
    @endif 
     
    <script>
        const eliminarRegistro = function(event){
            
            const idsop = $(event.target).parent().parent().find('input[type="hidden"]').val();
            //Eliminas con AJAX el insumo (mandas el id)
            console.log(idsop);
            let ids = $(event.target).parent().parent().find('input[type="hidden"]').val();
            let iPro;
            
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
                                async : false,
                                url: '{{ route('getInsumoPro') }}',
                                data: {'ids': ids},
                                success: function(response){
                                idPro = (response);
                                } 
                            });
                            Swal.fire(
                                '¡Insumo eliminado!',
                                '',
                                'success'
                                );
                                
                                $(event.target).parent().parent().remove();    
                        }
                    })
            //Eliminas la fila de la tabla
           
            
            

                
                    
            
            console.log("#cajaDetallee".val());
        }

    function resetform() {
            $(".id_insumo").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        }
        
        let arrayInsumos = [];
        let objInsumo = {};
        
        let objInsumoPro = {};
        
        
        $(document).ready(function(){           
            $('.id_insumo').select2({
            placeholder: "Seleccione Insumo"
        });

        
        
     
        $('.crearPdt').submit(function(e){
            
            $.ajax({
                                type: "GET",
                                async : false,
                                url: '{{ route('getInsumoPro') }}',
                                data: {'ids': ids},
                                success: function(response){
                                idPro = (response);
                                } 
                            });
           

            let arrayInsumosPro = [];
            let idAI=$('#idProd').val() ;
            $.ajax({
                                type: "GET",
                                async : false,
                                url: '{{ route('getInsumoProList') }}',
                                data: {'idA': idA},
                                success: function(response){
                                    arrayInsumosPro = (response);
                                } 
                            });
                            console.log(arrayInsumosPro.length); 
                            e.preventDefault();
                            if ((arrayInsumos.length) < 1 && (arrayInsumosPro.length) < 1) {
                    e.preventDefault();
                    Swal.fire(
                        '¡Ups!',
                        'Debes asociar insumos.',
                        'warning'
                        )
                }   
                                                             
                    if ($('#nombre').val() == "" || $('#precio').val() == "" ) {
                    e.preventDefault();
                    Swal.fire(
                        '¡Ups!',
                        'Realiza el registro correctamente.',
                        'warning'
                        )
                }  
                e.preventDefault();           
                 if ($('#nombre').val() != "" && $('#precio').val() != "" ) {
                    if ((arrayInsumos.length) > 0 || (arrayInsumosPro.length) > 0) {
                        
                          
                    e.preventDefault();
                        Swal.fire({
                    title: 'Editar producto',
                    text: "¿Está seguro de editar este producto?",
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
                    } 
                    
                
            

            });
            
           
            
                    
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
                            <button type="button" class="btn btn-sm btn-danger active"  onclick="eliminarInsumo(${objInsumo.idInsumo })" >Eliminar</button>
                            </td>
                        </tr>
                    `);
                    
                }
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