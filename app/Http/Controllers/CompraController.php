<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Proveedores;
use App\Models\Detallecompra;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use PDF;



class CompraController extends Controller
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
/*         $compras =Compra::all();
 */      $compras =Compra::where('estado', '!=',0)->get();
         $proveedores=Proveedores::all();

        return view('compra.index', compact('proveedores'))->with('compras', $compras);
        
    }
    
    public  function allCC(Request $request)
    { 
        $compras = \DB::table('compras')
        ->select('compras.*')
        ->orderBy('totalcompra','DESC')
        ->get();

         return response(json_encode($compras),200)->header('Content-type','text/plain');
    }

     public function Cancelar()
    {
         $compras =Compra::where('estado', '!=',1)->get();
         $proveedores=Proveedores::all();
        return view('compra.cancelar', compact('proveedores'))->with('compras', $compras);
        
    }
    public function Reporte()
    {
         $compras =Compra::where('estado', '!=',1)->get();
         $proveedores=Proveedores::all();
        return view('compra.reporte', compact('proveedores'))->with('compras', $compras);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores=Proveedores::where('estado', '=',1)->get();
        $insumos =Insumo::where('estado', '=',1)->get();
        return view('compra.crearCompras',compact("insumos"))->with('proveedores', $proveedores); 
     
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function save(Request $request){

        $request->validate([ 
            'numReciboCompra' => 'required',
            'id_proveedor'=>'required',
            'fecha'=>'required',
         
         ]);

        if (count($request-> id_insumo)==null  || count($request ->cantidad)==null   ){
            return redirect('compras/create')->with('error','True');
        }
        try {
            DB::beginTransaction();
            $compra = Compra::create([
                    'numReciboCompra' =>$request ->numReciboCompra,
                    'fecha' =>$request ->fecha,
                    'id_proveedor' =>$request ->id_proveedor,
                    'totalcompra' =>$request ->totalcompra     


            ]);

            foreach ($request->id_insumo as $key => $value) {
                detalleCompra::create([
                    'id_compra'=>$compra ->id,
                    'id_insumo' =>$value,
                    'cantidad' =>$request ->cantidad [$key],
                    'precio_unitario' =>$request ->precio_unitario [$key],
                    'iva'=>$request ->iva[$key],
                    'subtotal' =>$request ->subtotal [$key],
                    'precio_total'=>$request ->precio_total  [$key],
                ]);
                $insumo = Insumo::findOrFail($value);
                $insumo ->update([        
                    'id_insumo' =>$insumo ->cantidad += $request->cantidad[$key]
                    
                ]);
            }

            DB::commit();
            return redirect('compras')->with('guardar','True');

        } catch (QueryException $e) {
            DB::rollBack(); 
            return redirect('/compras/create')->with('errorregistro','errorregistro');

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
   
        $detallecompra =detallecompra::where('id_compra',$id);

        $insumo =Insumo::find($id);
        $compra =Compra::find($id);
        return view('compra.show' ,compact('detallecompra'))->with('compra',$compra);   


    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*     public function edit($id)
    {
        $compra =Compra::find($id);
        $detallecompras=Detallecompra::where('id_compra',$id);
        return view('compra.edit',compact('detallecompras'))->with('compra',$compra);

    }
 */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

/*
 public function update(Request $request, $id)
    {
        $compra= Compra::find($id);
            
        $compra->numReciboCompra=$request->get('numReciboCompra');
        $compra->fecha=$request->get('fecha');
        $compra->id_proveedor=$request->get('id_proveedor');
        $compra->totalcompra =$request->get('totalcompra');

        foreach ($request->id_insumo as $key => $value) {
            $compra->detallecompra($id,$value, $request ->cantidad [$key]);
        }

        $compra->save();
        return redirect('/compras');  
    } 
*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        
        $compra = Compra::find($id);
        if ($compra->estado == 1) {
            return redirect('compras')->with('error', 'True');     
        }else {
    
            $compra->delete();
            return redirect('compras')->with('cancelar', 'True');
        }
        
    
    }

    public function cambioEstadoCompra (Compra $compra)
    {
         if($compra->estado == 0)  {
             $compra->update(['estado'=>1]);
         }elseif ($compra->estado == 1) {
             $compra->update(['estado'=>0]);
             foreach ($compra->insumos as $insumo) {
                $cantidad = Insumo::find($insumo->id) ->cantidad-$compra->getCantidad($compra->id,$insumo->id);
                $insumo->cantidad = $cantidad;
                $insumo->save();
/* 
                echo($cantidad);
                echo("***");
                echo($compra->getCantidad($compra->id,$insumo->id)); */
             }         


         }else{             
         }
           return redirect()->back();    
     }
     public function genFacC($id){
        
        $detallecompras =Detallecompra::where('id_compra',$id);
        $compras =Compra::find($id);
        $data = ['detallecompras'=>$detallecompras, 'compras'=>$compras];
        return PDF::loadView('compra.pdfC', $data)->setPaper('a5', '')->setWarnings(false)->stream("$compras->id.pdfC");
        
    }

    public  function allC(Request $request)
    { 
        $hasta=$request->hasta;
        $desde=$request->desde;
        $proMasVenNo = DB::table('compras as c')
        ->selectRaw('sum(c.totalcompra) as Egresos, (Select sum(total) from ventas where cancelado = 0 and pago = 1) as Ingresos')
        ->where('c.estado',1)
        ->whereBetween('c.fecha', [$desde, $hasta])
        ->take(5)
        ->get();
    
         return response(json_encode($proMasVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allC2(Request $request)
    { 
        $hasta=$request->hasta;
        $desde=$request->desde;

        $proMenosVenNo = DB::table('detalleventas as vd')
        ->join('insumoproductos as ip', 'vd.id_producto' ,'=', 'ip.id_producto')
        ->join('insumos as i', 'i.id' ,'=', 'ip.id_insumo')
        ->join('ventas as v', 'v.id' ,'=', 'vd.id_venta')
        ->selectRaw('i.nombre_insumo as Insumo, sum(vd.cantidad*ip.cantidad) as Cantidad')
        ->whereBetween('v.fecha', [$desde, $hasta])
        ->groupBy('i.nombre_insumo')
        ->take(5)
        ->get();

         return response(json_encode($proMenosVenNo),200)->header('Content-type','text/plain');
    } 
    public  function allC3(Request $request)
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

    public  function allC4(Request $request)
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
}
