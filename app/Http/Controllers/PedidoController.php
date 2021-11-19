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



class PedidoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas=Venta::where('estado', '!=',4)->where('cancelado', '=',0)->get();
        $clientes=Cliente::all();
        return view ('pedido.index', compact('clientes'))->with('ventas', $ventas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes=Cliente::all();
        $detalleventas=DetalleVenta::all();
        $productos=Producto::where('estado', '=',1)->get();
        return view('pedido.create', compact('clientes', 'productos', 'detalleventas'))
        ->with('clientes', $clientes, 'productos', $productos, 'detalleventas', $detalleventas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (($request-> idProducto)==null || ($request ->cantidad)==null){
            return redirect('/pedidos/create')->with('malpedido', 'Realiza el pedido correctamente.');
        }
        elseif (count($request-> idProducto)<1 || count($request ->cantidad)<1){
            return redirect('/pedidos/create')->with('malpedido', 'Realiza el pedido correctamente.');
        }
        else{
            $date = Carbon::now()->toDateTimeString();
            $cedula=$request->get('id_cliente');
            $idCliente = PedidoController::getCliente($cedula);
            $idRecibo = PedidoController::genCodRec();
            try {
                DB::beginTransaction();
                    $ventas = new Venta();
                    $ventas->id_recibo = $idRecibo;
                    $ventas->id_cliente = $idCliente; 
                    $ventas->fecha = $date;
                    $ventas->total = $request->get('totalVentaV');
                    if ($request->get('pago')!=null) {
                    $ventas->pago = $request->get('pago');}
                    $ventas->formaPago = $request->get('formaPago');
                $ventas->saveOrFail();

                foreach ($request->idProducto as $key => $value) {
                    detalleVenta::create([
                        'id_venta'=>$ventas->id,
                        'id_producto' =>$value,
                        'cantidad' =>$request ->cantidad [$key],
                        'precio_unitario' =>$request ->precioUnitario [$key],
                        'precio_total'=>$request ->subTotal [$key]
                    ]);
                    $insumos=DB::table('insumoproductos')->select('id_insumo')->where('id_producto', '=', $value)->get();
                    $cantidadde=DB::table('insumoproductos')->select('cantidad')->where('id_producto', '=', $value)->get();
                    $cantidadDecremento = array_column($cantidadde->toArray(), 'cantidad');
                    $insumosId = array_column($insumos->toArray(), 'id_insumo');
                    foreach ($insumosId as $keyy => $valuee) {
                        DB::table('insumos')->where('id', '=', $valuee)->decrement('cantidad', $cantidadDecremento[$keyy]*(int)$request ->cantidad [$key]);
                    }
                }
                fechaestado::create([
                    'id_venta'=>$ventas->id,
                    'fecha' =>$date
                ]);

                DB::commit();
                return redirect('pedidos')->with('pedidoOk', 'pedidoOk');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect('pedidos')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
            }
        }
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
        return view('pedido.show',compact('detalleventas', 'fechaestados'))->with('ventas',$ventas,'fechaestado',$fechaestados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientes=Cliente::all();
        $ventas=Venta::find($id);
        if ($ventas->pago==1) {
            return redirect('pedidos')->with('noEditar', 'Este pedido no se puede editar, ya está pago!');
        }
        else {
        $detalleventas=Detalleventa::where('id_venta',$id);
        return view('pedido.edit',compact('detalleventas', 'clientes'))->with('ventas',$ventas, 'clientes', $clientes);
        }
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
        $date = Carbon::now()->toDateTimeString();
        $ventas= Venta::find($id);
        $cedula=$request->get('id_cliente');
        $idCliente = PedidoController::getCliente($cedula);
        $ventas->id_cliente = $idCliente;

        $ventas->pago = $request->get('pago');
        $ventas->estado = $request->get('estado');
        $ventas->formaPago = $request->get('formaPago');
        $ventas->save();
        fechaestado::create([
            'id_venta'=>$id,
            'estado'=>$request->get('estado'),
            'fecha' =>$date
        ]);
        return redirect('pedidos')->with('editar', 'El pedido se ha modificado correctamente!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta = Venta::find($id);
        if ($venta->pago == 1 && $venta->estado > 0) {
            return redirect('pedidos')->with('error', 'El pedido no se ha podido cancelar!');    
        }else {

            $venta->update(['cancelado'=>1]); 
            $productId=DB::table('detalleventas')->select('id_producto')->where('id_venta', '=', $venta->id)->get();
            $productosId = array_column($productId->toArray(), 'id_producto');
            $cantidad=DB::table('detalleventas')->select('cantidad')->where('id_venta', '=', $venta->id)->get();
            $cantidadAum = array_column($cantidad->toArray(), 'cantidad');
            foreach ($productosId as $key => $value) {
                $insumos=DB::table('insumoproductos')->select('id_insumo')->where('id_producto', '=', $value)->get();
                $cantidadde=DB::table('insumoproductos')->select('cantidad')->where('id_producto', '=', $value)->get();
                $cantidadDecremento = array_column($cantidadde->toArray(), 'cantidad');
                $insumosId = array_column($insumos->toArray(), 'id_insumo');
                foreach ($insumosId as $keyy => $valuee) {
                    DB::table('insumos')->where('id', '=', $valuee)->increment('cantidad', $cantidadDecremento[$keyy]*(int)$cantidadAum[$key]);
                }
            }
            return redirect('pedidos')->with('cancelar', 'El pedido se ha cancelado correctamente!');
        }
    }



    public function cambioEstadoPago (Venta $venta)
   {
    $date = Carbon::now()->toDateTimeString();
        $venta->update(['estado'=>4]);
        $venta->update(['pago'=>1]);
        fechaestado::create([
            'id_venta'=>$venta->id,
            'estado'=>4,
            'fecha' =>$date
        ]);
         return redirect()->back();
   }



   public function cambioEstadoPedido (Venta $venta)
   {
    $date = Carbon::now()->toDateTimeString();
        if($venta->estado == 0)  {
            $venta->update(['estado'=>1]);
            fechaestado::create([
                'id_venta'=>$venta->id,
                'estado'=>1,
                'fecha' =>$date
            ]);
        }elseif ($venta->estado == 1) {
            $venta->update(['estado'=>2]);
            fechaestado::create([
                'id_venta'=>$venta->id,
                'estado'=>2,
                'fecha' =>$date
            ]);
        }elseif ($venta->estado == 2){
            $venta->update(['estado'=>3]);
            fechaestado::create([
                'id_venta'=>$venta->id,
                'estado'=>3,
                'fecha' =>$date
            ]);
        }elseif ($venta->estado == 3){
            $venta->update(['estado'=>4]);
            fechaestado::create([
                'id_venta'=>$venta->id,
                'estado'=>4,
                'fecha' =>$date
            ]);
        }else{}
        return redirect()->back();    
   }


   public function getCliente($cedula){
        $id=DB::table('clientes')->select('id')->where('cedula', '=', $cedula)->pluck('id')->first();
        return $id;
    }

    public function getClientee(Request $request){
        $cedula = (int)$request->cedula;
        $id=DB::table('clientes')->select('id')->where('cedula', '=', $cedula)->pluck('id')->first();
        echo $id;
    }

    public function getPrecioProducto(Request $request){
        $idProducto = $request->idProducto;
        $id=DB::table('productos')->select('precio')->where('id', '=', $idProducto)->pluck('precio')->first();
        echo $id;
    }

    public function getStockProducto(Request $request){
        $insumosCantidad=0;
        $idProducto = (int)$request->idProducto;
        $cantidad = (int)$request->cantidad;
        $insumos=DB::table('insumoproductos')->select('id_insumo')->where('id_producto', '=', $idProducto)->get();
        $cantidadde=DB::table('insumoproductos')->select('cantidad')->where('id_producto', '=', $idProducto)->get();
        $cantidadDecremento = array_column($cantidadde->toArray(), 'cantidad');
        $insumosId = array_column($insumos->toArray(), 'id_insumo');
        
        foreach ($insumosId as $keyy => $valuee) {
            $insumosCantidad=DB::table('insumos')->select('cantidad')->where('id', '=', $valuee)->where('cantidad', '>', ($cantidadDecremento[$keyy]*$cantidad))->pluck('cantidad')->first();
            if ($insumosCantidad == null || $insumosCantidad == 0) {
                break;
            }
        }
        echo $insumosCantidad;
    }

    public function codId(){
        $id=DB::table('ventas')->select('id')->orderBy('id','DESC')->pluck('id')->first();
        echo $id;
    }
    
    public function genCodRec(){
        $id=DB::table('ventas')->select('id')->orderBy('id','DESC')->pluck('id')->first();
        echo $id;
        if ($id == null) {$id = "EPF-000";}
        else {$id = "EPF-".($id+1);}
        return $id;
    }

    public function genFac($id){
        
        $detalleventas =Detalleventa::where('id_venta',$id);
        $ventas =Venta::find($id);
        $data = ['detalleventas'=>$detalleventas, 'ventas'=>$ventas];
        return PDF::loadView('pedido.pdf', $data)->setPaper('a5', '')->setWarnings(false)->stream("$ventas->id_recibo.pdf");
        
    }
}
