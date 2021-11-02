<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\VentaController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dash', function () {
    return view('dash.index');

})->name('dash'); 

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('pedidos', 'App\Http\Controllers\PedidoController');

Route::resource('ventas', 'App\Http\Controllers\VentaController');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('facImp', 'App\Http\Controllers\PedidoController@genCodRec')->name('genCodRec');

Route::get('cambioEstadoPago/pedidos/{venta}', 'App\Http\Controllers\PedidoController@cambioEstadoPago')->name('pedidos.cambioEstadoPago');

Route::get('cambioEstadoPedido/pedidos/{venta}', 'App\Http\Controllers\PedidoController@cambioEstadoPedido')->name('pedidos.cambioEstadoPedido');

Route::get('priceGet',[PedidoController::class,'getPrecioProducto'])->name('getPrice');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
