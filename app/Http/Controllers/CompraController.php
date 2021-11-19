<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Proveedores;
use App\Models\Detallecompra;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;



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
        $compras =Compra::all();
/*          $compras =Compra::where('estado', '!=',0)->get();
 */           $proveedores=Proveedores::all();

        return view('compra.index', compact('proveedores'))->with('compras', $compras);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view ('compra.create');
        $proveedores=Proveedores::all();
        $insumos =Insumo::all();
        return view('compra.crearCompras',compact("insumos"))->with('proveedores', $proveedores); 
     
    }

    public function createInsumo()
    {
        $proveedores=Proveedores::all();
        $insumos =Insumo::all();
        return view('compra.crearCompras',compact("insumos"))->with('proveedores', $proveedores); 
    }
    public function save(Request $request){

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
   /*  public function store(Request $request)
    {
        $compras= new Compra();
        $insumos= new Insumo();
        $detallecompras= new Detallecompra();


        $compras->numrecibocompra=$request->get('numrecibocompra');
        $compras->fecha=$request->get('fecha');
        $compras->id_proveedor=$request->get('id_proveedor');
        $compras->totalcompra =$request->get('totalcompra');

        $insumos->nombre_insumo =$request->get('nombre_insumo');
        $insumos->cantidad =$request->get('cantidad');
        


        $compras->save();
        $insumos->save();
        $detallecompras->id_insumo= $insumos->id;
        $detallecompras->id_compra= $compras->id;
        $detallecompras->cantidad= $request->get('cantidadc');
        $detallecompras->precio_unitario =$request->get('precio_unitario');
        $detallecompras->precio_total =$request->get('precio_total');
        


        $detallecompras->save();


        return redirect('/compras');
        


    } */
   
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
    public function edit($id)
    {
      /*  $id=$request->id;
        $detalles = Detallecompra::join('insumos','detallecompra .id_insumo', '=','insumos.id')
        ->selec ('detallecompra .cantidad','detallecompra.precio_total','insumos.cantidad as insumo')
        ->where ('detallecompra.id_compra','=',$id)
        ->orderBy('detallecompra.id', 'desc')->get();

        
        $db=mysqli_connect("localhost", "root", "" ,"piloncitosoft");
        $rs=mysqli_query($db,"SELECT (nombre_insumo),(cantidad) FROM detallecompras
        WHERE id_compra '==' ()");*/

        $compra =Compra::find($id);
        $detallecompras=Detallecompra::where('id_compra',$id);
        return view('compra.edit',compact('detallecompras'))->with('compra',$compra);

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
        $compra= Compra::find($id);
            
        $compra->numReciboCompra=$request->get('numReciboCompra');
        $compra->fecha=$request->get('fecha');
        $compra->id_proveedor=$request->get('id_proveedor');
        $compra->totalcompra =$request->get('totalcompra');

        foreach ($request->id_insumo as $key => $value) {
            $compra->detallecompra($id,$value, $request ->cantidad [$key]);
        }

        $compra->save();
        return redirect('/compras');    }

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
        
 /*        $compra = Compra::find($id);
        if ($compra->estado == 1) {
            $compra->update(['estado'=>0]); 

            return redirect('compras')->with('cancelar', 'True');
        }
 */
    
    }
    
    /* public function  camEstadoC(Request $request) 
    {
     
    $ComprasUpdate = Compra::findOrFail($request->id)->update(['estado' => $request->estado]); 

    if($request->estado == 0)  {
        $newStatus = 'Cancelado';

        
    }else{
        $newStatus ='Activado';
    }

    return response()->json(['var'=>''.$newStatus.'']);
    } */


    public function cambioEstadoCompra (Compra $compra)
    {
         if($compra->estado == 0)  {
             $compra->update(['estado'=>1]);
         }elseif ($compra->estado == 1) {
             $compra->update(['estado'=>0]);
         }else{}
         return redirect()->back();    
    }
}
