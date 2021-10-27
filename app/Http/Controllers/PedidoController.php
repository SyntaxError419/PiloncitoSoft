<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Detalleventa;
use App\Models\Cliente;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        if (count($request-> idProducto)<1 || count($request ->cantidad)<1){
            return redirect('/pedidos')->withErrors('Realiza la venta correctamente.');
        }
        $cedula=$request->get('id_cliente');
        $idCliente = PedidoController::getCliente($cedula);
        $idRecibo = PedidoController::genCodRec();
        try {
            DB::beginTransaction();
            $date = Carbon::now()->toDateTimeString();
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
            }
            DB::commit();
            return redirect('pedidos')->with('success','Se guardo el pedido');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('pedidos')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
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
        $productos =Producto::find($id);
        $ventas =Venta::find($id);
        return view('pedido.show',compact('detalleventas'))->with('ventas',$ventas);
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
        $detalleventas=Detalleventa::where('id_venta',$id);
        return view('pedido.edit',compact('detalleventas', 'clientes'))->with('ventas',$ventas, 'clientes', $clientes);
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
        $ventas= Venta::find($id);
        $cedula=$request->get('id_cliente');
        $idCliente = PedidoController::getCliente($cedula);
        $ventas->id_cliente = $idCliente;

        $ventas->pago = $request->get('pago');
        $ventas->estado = $request->get('estado');
        $ventas->formaPago = $request->get('formaPago');

        $ventas->save();
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
        if ($venta->pago == 1) {
            return redirect('pedidos')->with('error', 'El pedido no se ha podido cancelar!');    
        }else {
            $venta->update(['cancelado'=>1]); 
            return redirect('pedidos')->with('cancelar', 'El pedido se ha cancelado correctamente!');
        }
    }



    public function cambioEstadoPago (Venta $venta)
   {
        $venta->update(['estado'=>4]);
        $venta->update(['pago'=>1]);
         return redirect()->back();    
   }



   public function cambioEstadoPedido (Venta $venta)
   {
        if($venta->estado == 0)  {
            $venta->update(['estado'=>1]);
        }elseif ($venta->estado == 1) {
            $venta->update(['estado'=>2]);
        }elseif ($venta->estado == 2){
            $venta->update(['estado'=>3]);
        }elseif ($venta->estado == 3){
            $venta->update(['estado'=>4]);
        }else{}
        return redirect()->back();    
   }


   public function getCliente($cedula){
    $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
    $rs = mysqli_query($db, "SELECT (id) AS id FROM clientes WHERE cedula=$cedula");
    if ($row = mysqli_fetch_row($rs)) {
        $id = trim($row[0]);}
        return $id;
    }

    public function getProducto($nombreProducto){
        $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
        $rs = mysqli_query($db, "SELECT (id) AS id FROM productos WHERE nombre='$nombreProducto'");
        if ($row = mysqli_fetch_row($rs)) {
            $id = trim($row[0]);
        }
        return $id;
    }


    public function getPrecioProducto(Request $request){
        $idProducto = $_REQUEST['idProducto'];
        $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
        $rs = mysqli_query($db, "SELECT precio FROM productos WHERE id=$idProducto");
        if ($row = mysqli_fetch_row($rs)) {
            $id = trim($row[0]);
        }
        echo ($id);
    }

    public function genCodRec(){
        $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
        $rs = mysqli_query($db, "SELECT MAX(id) AS id FROM ventas");
        if ($row = mysqli_fetch_row($rs)) {
        $id = trim($row[0]);
        }
        if ($id == null) {$id = "EPF-000";}
        else {$id = "EPF-".($id+1);}
        return $id;
    }
}
