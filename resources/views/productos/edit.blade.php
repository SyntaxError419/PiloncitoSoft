@extends('layouts.plantillabase')

@section('contenido')
<style type="text/css">
h1 {text-align: center}
h2 {text-align: left}

h4 {display: inline}
h3, h4 {text-align: right}
.lcd{text-align: right}
</style>
<div class="card mt-4">
    <div class="card-header mb-2">
        Editar Producto
    </div>
    <div class="card-body">
        <div class="card">
            <form action="/productos/{{$productos->id}}" method ="POST">
            
                @method('PUT')  
                <div class="card-header">

                
                    <div class="form-group">
                    <div class="mb-3">
                  <label for="" class="form-label">Nombre</label>
                    <input id="nombre" name="nombre" class="form-control" value="{{$productos->nombre}}" tabindex="1" required="required">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Precio</label>
                  <input id="precio" name="precio" type="number" step="any" class="form-control" value="{{$productos->precio}}" tabindex="2" required="required">
                </div>
                    
                     <div class="mb-3">
                        <label for="id_insumo" class="form-label">Insumo:</label>
                            <select class="form-control" name="id_insumo" id="id_insumo">
                                <option value="">Seleccione el insumo</option>
                                @foreach($insumos as $i)
                                    <option value="{{ $i->id }}">{{ $i->nombre_insumo }}</option>
                                @endforeach
                            </select>
                        </div>
                     </div>
                        
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" class="form-control" name="cantidad" id="cantidad">
                        </div>
                        <div >
                           
                            <button type="button" id="agregarInsumo" class="btn btn-secondary mt" style="float: left;">Agregar</button>
                        </div>
                        
                    </div>
                    
                    <div class="card-body">
                        <table class="table bg-gray mt-2" style="border-radius: 5px;">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="cajaDetalle">
                            
                  
                            @foreach ($insumoproductos as $in)
              
                            <tr>
                            <td>{{$in->nombre_insumo}}</td>
                            <td>{{$in->cantidad}}</td>
                           
                           
           
              
                            <td>
                           
                        <form action="{{ route('insudestroy',$in->id) }}" class="d-inline formulario-eliminar" method="POST">
                  
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
                            
                    </div>

                    <tbody>
             
           </tbody>
                 
                    <div>
                    <a href="/productos" class="btn btn-secondary" tabindex="6">Cancelar</a>
                    <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                    </div>
                </form>
            
        </div>
    </div>
@endsection

@section('js')
    <script> 
        function myFunction()  {
            $("form select").each(function() { this.selectedIndex = 0 });
            $("form input[type=text]").each(function() { this.value = '' });
        
        }
        let arrayInsumos = [];
        let objInsumo = {};
        
        $(document).ready(function(){
            
            $('#agregarInsumo').click(function(){
                if (parseInt($('#cantidad').val()) > 0) {
                    
                    let idInsumo = parseInt($('#id_insumo option:selected').val());
                    let insumo = $('#id_insumo option:selected').text();
                    let cantidad =parseInt($('#cantidad').val());

                    let indexInsumo = getIndexInsumo(idInsumo);

                    console.log(arrayInsumos)
                    console.log(idInsumo)

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
                                <button type="button" class="btn btn-sm btn-danger"  onclick="eliminarInsumo(${objInsumo.idInsumo })" ><i class="fas fa-trash"></i></button>
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