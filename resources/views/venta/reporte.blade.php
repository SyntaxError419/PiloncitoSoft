<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
        th { font: bolder; }
        .negritas {font-weight: bold; }
 </style>
<body>
<div class="container shadow-lg p-3 mb-5 mt-5 bg-body rounded">
        <div class="row">
            <div class="col">
 <table id="myTable" class="table table-striped" style="width:100%">
        <thead class="bg-primary text-white">
        <tr class="negrita">
            <th colspan="2" scope="col-4">Id. Recibo</th>
            <th colspan="5" scope="col-4">Cliente</th>
            <th colspan="3" scope="col-4">Fecha</th>
            <th colspan="2" scope="col-4">Total</th>
            <th colspan="3" scope="col-4">Forma de pago</th>
            <th colspan="2" scope="col-4">Estado</th>
        </tr>
        </thead>
        
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td colspan="2">{{$venta->id_recibo}}</td>
                <td colspan="5">{{$venta->clientes->cedula}} - {{$venta->clientes->nombre}}</td>
                <td colspan="3">{{$venta->fecha}}</td>
                <td colspan="2">${{number_format($venta->total)}}</td> 
                <td colspan="3">{{$venta->formaPago}}</td>
                <td colspan="2">
                @if($venta->estado == 0)
                    <p>Por iniciar</p>
                @elseif($venta->estado == 1)
                    <p>En proceso</p>
                @elseif($venta->estado == 2)
                    <p>Por entregar</p>
                @elseif($venta->estado == 3)
                    <p>En entrega</p>
                @else
                    <p>Entregado</p>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>


    <h4>Total de ganancias:</h4>
    <p>${{number_format($totalventas)}}</p>
    

     <!-- jquery y bootstrap -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
 
 <!-- datatables con bootstrap -->
 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

 <!-- Para usar los botones -->
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <!-- Para los estilos en Excel     -->
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>
<script>
$(document).ready(function () {
    $("#myTable").DataTable({
        dom: "Bfrtip",
        buttons:{
            dom: {
                button: {
                    className: 'btn'
                }
            },
            buttons: [
            {
                //definimos estilos del boton de excel
                extend: "excel",
                text:'Exportar a Excel',
                className:'btn btn-outline-success',

                // 1 - ejemplo básico - uso de templates pre-definidos
                //definimos los parametros al exportar a excel
                
                excelStyles: {                
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 
                    
                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ] 
                    
                },
                

                // 2 - estilos a una fila   

                excelStyles: {                      // Add an excelStyles definition
                    cells: "2",                     // adonde se aplicaran los estilos (fila 2)
                    style: {                        // The style block
                        font: {                     // Style the font
                            name: "Arial",          // Font name
                            size: "14",             // Font size
                            color: "FFFFFF",        // Font Color
                            b: true,               // negrita SI
                        },
                        fill: {                     // Estilo de relleno (background)
                            pattern: {              // tipo de rellero (pattern or gradient)
                                color: "ff7961",    // color de fondo de la fila
                            }
                        }
                    }
                },
                */

                // 3 - uso de condiciones

                 excelStyles: {
                    cells: 'sD', //(s) de Smart - Referencia de celda inteligente, todas las filas de datos en la columna D (en este caso Edad)
                    condition: {                    // Add the style conditionally
                        type: 'cellIs',             // Using the cellIs type
                        operator: 'between',        // Operator a usar "Entre"
                        formula: [35,50],    // arreglo de valores requeridos para el operador 'entre' (edades entre 35 y 50 años son pintadas)
                    },
                    style: {
                        font: {
                            b: true,                // Make the font bold
                        },
                        fill: {                     // Style the cell fill (background)
                            pattern: {              // Type of fill (pattern or gradient)
                                bgColor: 'e8f401',  // Fill color (be aware of the Excel gotcha that conditonal fills                                
                            }
                        }
                    }
                }


                // 4 - Reemplazar o insertar celdas, columnas y filas

                // 4.1 - Añadir columnas

                insertCells: [                  // Agregar una opción de configuración insertCells
                    {
                        cells: 'sCh',               // la "s" de Smart, "C" es la columna y "h" se refiere al header,
                        content: 'Nueva columna C',    // nombre del encabezado de la columna que insertamos
                        pushCol: true,              // pushCol hace que se inserte la columna
                    },
                    {
                        cells: 'sC1:C-0',           // Target the data
                        content: 'C',                // Add empty content
                        pushCol: true               // empuja las columnas a la derecha para insertar el nuevo contenido
                    }                    
               ],
                excelStyles: {
                    template: 'cyan_medium',    // Add a template to the result
                }


                // 4.2 - Insertar filas

                insertCells: [                  // Agregar una opción de configuración insertCells                   
                    {
                        cells: 's5:6',              // Inserta los datos en las filas 5 y 6 contando desde el encabezado
                        content: 'Celdas nuevas',   // contenido a insertar
                        pushRow: true               // empuja las filas hacia abajo para insertar el contenido                    
                    },
                    {
                        cells: 'B3',                // Celda B3
                        content: 'Esta es la celda B3', // Simplemente sobreescribimos su contenido                                                    
                    }
               ],
                excelStyles: {
                    template: 'cyan_medium',    // Add a template to the result
                }



            // ejemplo para IMPRIMIR
           
            pageStyle: {
                sheetPr: {
                    pageSetUpPr: {
                        fitToPage: 1            // Fit the printing to the page
                    } 
                },
                printOptions: {
                    horizontalCentered: true,
                    verticalCentered: true,
                },
                pageSetup: {
                    orientation: "landscape",   // Orientacion
                    paperSize: "9",             // Tamaño del papel (1 = Legal, 9 = A4)
                    fitToWidth: "1",            // Ajustar al ancho de la página
                    fitToHeight: "0",           // Ajustar al alto de la página
                },
                pageMargins: {
                    left: "0.2",
                    right: "0.2",
                    top: "0.4",
                    bottom: "0.4",
                    header: "0",
                    footer: "0",
                },
                repeatHeading: true,    // Repeat the heading row at the top of each page
                repeatCol: 'A:A',       // Repeat column A (for pages wider than a single printed page)
            },
            excelStyles: {
                template: 'blue_gray_medium',    // Add a template style as well if you like
            }   

            }
            ]            
        }            
    });
});
    </script>
</body>
</html>