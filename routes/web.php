<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\InsumoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('auth.login');
}); 

Route::resource('proveedores','App\Http\Controllers\ProveedoresController');


Route::resource('users','App\Http\Controllers\UsersController');


Route::middleware(['auth:sanctum', 'verified'])->get('/dash', function () {
    return view('dash.index');

})->name('dash'); 

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('pedidos', 'App\Http\Controllers\PedidoController');

Route::resource('ventas', 'App\Http\Controllers\VentaController');

Route::resource('clientes', 'App\Http\Controllers\ClienteController');

Route::resource('productos', 'App\Http\Controllers\ProductoController');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('facImp', 'App\Http\Controllers\PedidoController@genCodRec')->name('genCodRec');

Route::get('idCod', 'App\Http\Controllers\PedidoController@codId')->name('getCodId');

Route::get('cambioEstadoPago/pedidos/{venta}', 'App\Http\Controllers\PedidoController@cambioEstadoPago')->name('pedidos.cambioEstadoPago');

Route::get('cambioEstadoPedido/pedidos/{venta}', 'App\Http\Controllers\PedidoController@cambioEstadoPedido')->name('pedidos.cambioEstadoPedido');

Route::get('camStado', 'App\Http\Controllers\ClienteController@camStado')->name('camStado');

Route::get('camtado', 'App\Http\Controllers\ProductoController@camtado')->name('camtado');
 
Route::get('priceGet',[PedidoController::class,'getPrecioProducto'])->name('getPrice');

Route::get('stockGet',[PedidoController::class,'getStockProducto'])->name('getStock');

Route::get('masStockGet',[PedidoController::class,'getStockMasProducto'])->name('getStockMas');

Route::get('stockeGet',[PedidoController::class,'getStockeProductos'])->name('getStocke');

Route::get('clientGet',[PedidoController::class,'getClientee'])->name('getClient');

Route::get('excelVentasExport',[VentaController::class,'exportExcelVentas'])->name('exportExcelVentas');

Route::get('pdf/pedidos/{venta}', 'App\Http\Controllers\PedidoController@genFac')->name('pdf');

Route::get('pdfC/compras/{compra}', 'App\Http\Controllers\CompraController@genFacC')->name('pdfC');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::resource('insumos','App\Http\Controllers\InsumoController');
Route::resource('compras','App\Http\Controllers\CompraController');
Route::get('cancelar', [App\Http\Controllers\CompraController::class, 'cancelar'])->name('cancelar');

Route::get('reporte', [App\Http\Controllers\CompraController::class, 'reporte'])->name('reporte');
Route::get('reportes', [App\Http\Controllers\InsumoController::class, 'reportes'])->name('reportes');

Route::post('/reporte/allC/',[CompraController::class,'allC'])->name('allC');

Route::post('/reportes/all/',[InsumoController::class,'all'])->name('all');
Route::post('/reportes/all2/',[InsumoController::class,'all2'])->name('all2');
Route::post('/reportes/all3/',[InsumoController::class,'all3'])->name('all3');

Route::get('/crearCompras',[CompraController::class,'create'])->name('crearCompra');
Route::post('/compras/guardar/compra',[CompraController::class,'save'])->name('guardarCompra');
Route::post('/guardarproducto',[App\Http\Controllers\ProductoController::class, 'save'])->name('guardarproducto');

Route::get('nombrerepetido',[ProductoController::class,'nombrerepetido'])->name('nombrerepetido');
Route::get('insuget',[ProductoController::class,'getInsumoProList'])->name('getInsumoProList');
Route::get('insumoProGet',[ProductoController::class,'getInsumoPro'])->name('getInsumoPro');
Route::get('getInsumoProList/productos','App\Http\Controllers\ProductoController@getInsumoProList')->name('getInsumoProList');
Route::get('getInsumoPro/productos','App\Http\Controllers\ProductoController@getInsumoPro')->name('getInsumoPro');
Route::get('cambioEstadoProducto/productos/{producto}', 'App\Http\Controllers\ProductoController@cambioEstadoProducto')->name('productos.cambioEstadoProducto');
Route::get('cambioEstadoCliente/clientes/{cliente}', 'App\Http\Controllers\ClienteController@cambioEstadoCliente')->name('clientes.cambioEstadoCliente');        
Route::get('cambioEstadoInsumo/insumos/{insumo}', 'App\Http\Controllers\InsumoController@cambioEstadoInsumo')->name('insumos.cambioEstadoInsumo');
Route::get('cambioEstadoCompra/compras/{compra}', 'App\Http\Controllers\CompraController@cambioEstadoCompra')->name('compras.cambioEstadoCompra');
Route::get('cambioEstadoProveedor/proveedores/{proveedor}', 'App\Http\Controllers\ProveedoresController@cambioEstadoProveedor')->name('proveedores.cambioEstadoProveedor');

