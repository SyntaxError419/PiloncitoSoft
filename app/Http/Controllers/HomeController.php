<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Detalleventa;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Fechaestado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public  function allV()
    { 
        $proMasVenNo = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->selectRaw('p.nombre, sum(dv.cantidad) as coun')
        ->where('v.cancelado',0)
        ->groupBy('dv.id_producto', 'p.nombre')
        ->orderBy('coun','DESC')
        ->take(5)
        ->get();

         return response(json_encode($proMasVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allV2()
    { 

        $proMenosVenNo = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->selectRaw('p.nombre, sum(dv.cantidad) as coun')
        ->where('v.cancelado',0)
        ->groupBy('p.id', 'p.nombre')
        ->orderBy('coun','ASC')
        ->take(5)
        ->get();

         return response(json_encode($proMenosVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allV3()
    {   
        $pedidoscanc = DB::table('ventas')
        ->selectRaw('cancelado, count(cancelado = 0) as pedidos')
        ->groupBy('cancelado')
        ->take(5)
        ->get();

         return response(json_encode($pedidoscanc),200)->header('Content-type','text/plain');
    }

    public  function allV4()
    { 

        $pedidoscanc = DB::table('ventas as v')
        ->selectRaw('v.formaPago, sum(v.total) as total')
        ->where('v.cancelado',0)
        ->Where('v.pago',1)
        ->groupBy('v.formaPago')
        ->take(5)
        ->get();

         return response(json_encode($pedidoscanc),200)->header('Content-type','text/plain');
    }
}
