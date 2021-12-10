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
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas=Venta::where('pago', '=',1)->where('cancelado', '=',0)->get();
        $clientes=Cliente::all();
        return view ('venta.index', compact('clientes'))->with('ventas', $ventas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalleventas =Detalleventa::where('id_venta',$id);
        $fechaestados =Fechaestado::where('id_venta',$id)->get();
        $productos =Producto::find($id);
        $ventas =Venta::find($id);
        return view('venta.show',compact('detalleventas', 'fechaestados'))->with('ventas',$ventas,'fechaestado',$fechaestados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Reportes()
    {
        $ventas =Venta::all();
        return view('venta.vistaReporte')->with ('ventas',$ventas);
    }

    public  function allV(Request $request)
    { 
        $hasta=$request->hasta;
        $desde=$request->desde;
        $proMasVenNo = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->selectRaw('p.nombre, sum(dv.cantidad) as coun')
        ->where('v.cancelado',0)
        ->whereBetween('v.fecha', [$desde, $hasta])
        ->groupBy('dv.id_producto', 'p.nombre')
        ->orderBy('coun','DESC')
        ->take(5)
        ->get();

         return response(json_encode($proMasVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allV2(Request $request)
    { 
        $hasta=$request->hasta;
        $desde=$request->desde;

        $proMenosVenNo = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->selectRaw('p.nombre, sum(dv.cantidad) as coun')
        ->where('v.cancelado',0)
        ->whereBetween('v.fecha', [$desde, $hasta])
        ->groupBy('p.id', 'p.nombre')
        ->orderBy('coun','ASC')
        ->take(5)
        ->get();

         return response(json_encode($proMenosVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allV3(Request $request)
    {   
        $hasta=$request->hasta;
        $desde=$request->desde;

        $pedidoscanc = DB::table('ventas')
        ->selectRaw('cancelado, count(cancelado = 0) as pedidos')
        ->whereBetween('fecha', [$desde, $hasta])
        ->groupBy('cancelado')
        ->take(5)
        ->get();

         return response(json_encode($pedidoscanc),200)->header('Content-type','text/plain');
    }

    public  function allV4(Request $request)
    { 
        $hasta=$request->hasta;
        $desde=$request->desde;

        $pedidoscanc = DB::table('ventas as v')
        ->selectRaw('v.formaPago, sum(v.total) as total')
        ->where('v.cancelado',0)
        ->Where('v.pago',1)
        ->whereBetween('v.fecha', [$desde, $hasta])
        ->groupBy('v.formaPago')
        ->take(5)
        ->get();

         return response(json_encode($pedidoscanc),200)->header('Content-type','text/plain');
    }

    public function exportExcelVentas(Request $request)
    {
        return Excel::download(new VentasExport, 'ventas.xlsx');
    }
}
