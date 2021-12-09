<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoCreateRequest;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\Insumoproducto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;




class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::orderBy('estado', 'DESC')->get();
        return view('productos.index')->with('productos',$productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insumos=Insumo::where('estado', '=',1)->get();;
        $insumoproducto=Insumoproducto::all();
        $productos=DB::table('productos')->select('nombre')->get('nombre');
        
        return view ('productos.create', compact('insumos', 'insumoproducto','productos'))->with('insumos', $insumos, 'insumoproducto', $insumoproducto,'productos', $productos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    

  
    


    public function save(Request $request){
        $request->validate([ //Validacion que me sea requeridos estos campos//
            'nombre' => 'required |unique:productos',
            'precio'=>'required'

         ]);

         if (($request-> id_insumo)==null || ($request ->cantidad)==null) {
            return redirect('/productos/create')->with('malpedido', 'Debes asociar minimo un insumo correctamente.');
        }

        else{

        try {
            DB::beginTransaction();
            $productos = new Producto();
            $productos->nombre =$request->get('nombre');
            $productos->precio =$request->get('precio');
            $productos->saveorfail();
            
            foreach ($request->idInsumo as $key => $value) {
                insumoproducto::create([
                    
                    'id_insumo'=>$value,
                    'id_producto'=>$productos->id,
                    'cantidad'=>$request->cantidad [$key],
                ]);
            }
            DB::commit();
            return redirect('productos')->with('creadopdtcorrec','creadopdtcorrec');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/productos')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
        }
    }
}
         
        


       

        public function getIsumo($nomInsumo){
            $id=DB::table('insumos')->select('id')->where('nomInsumo', '=', $nomInsumo)->pluck('id')->first();
            return $id;
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) 
    {   
     
        $productos =Producto::find($id);
        
        $insumosproductos=Insumoproducto::all();
        $insumos=Insumo::where('estado', '=',1)->get();;
        $insumoproductos = Insumoproducto::where('id_producto',$id)->join('insumos', 'insumoproductos.id_insumo', 'insumos.id')->select('insumos.nombre_insumo','insumoproductos.cantidad', 'insumoproductos.id')->get();
        return view('productos.edit',compact('insumoproductos','insumos'))->with('productos',$productos,'insumos',$insumos,'insumoproductos',$insumoproductos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, ProductoCreateRequest $validate, $id)
    {
        $insumoproductos = Insumoproducto::where('id_producto',$id)->join('insumos', 'insumoproductos.id_insumo', 'insumos.id')->select('insumos.nombre_insumo','insumoproductos.cantidad', 'insumoproductos.id')->get();
        $countinsumos=count($insumoproductos);
        
        try {
            DB::beginTransaction();
            $productos= Producto::find($id);
            $productos->nombre =$request->get('nombre');
            $productos->precio =$request->get('precio');
            
            $productos->save();
            if ($request->idInsumo != null) {
            foreach ($request->idInsumo as $key => $value) {
                
                      
                
                $id_insumo=$value;
                $id_producto=$productos->id;
                $cantidad=DB::table('insumoproductos')->select('cantidad')->where('id_producto', '=', $id_producto)->where('id_insumo', '=', $id_insumo)->pluck('cantidad')->first();
                $insumorep=DB::table('insumoproductos')->select('id')->where('id_producto', '=', $id_producto)->where('id_insumo', '=', $id_insumo)->pluck('id')->first();
                if ($cantidad != null ) {
                    $insumore= Insumoproducto::find($insumorep);
                    $cant=$request->cantidad [$key];
                    DB::table('insumoproductos')->where('id', '=', $insumorep)->increment('cantidad', +(int)$cant);
                                        
                    
                }else {
                    insumoproducto::create([
                    
                        'id_insumo'=>$value,
                        'id_producto'=>$productos->id,
                        'cantidad'=>$request->cantidad [$key],
                    ]);
                }
                
            }
        
            
            
            DB::commit();
            return redirect('productos')->with('modcor','modcor');
        }elseif ($countinsumos > 0 && $request->idInsumo==0) {
            return redirect('productos')->with('modcor','modcor');
        }
        elseif ($countinsumos < 0 && $request->idInsumo==0) {
        return redirect()->with('modcor','modcor');
        }
        else{
            return redirect()->back()->with('malpedido', 'malpedido'); 
            
        }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/productos')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {   $productoVenta=DB::table('detalleventas')->select('id_producto')->where('id_producto', '=', $id)->pluck('id_producto')->first();
        
        if ($productoVenta!=$id) {
            $productos = Producto::find($id);
            $productos ->delete();
            return redirect('/productos')->with('pdtelmdo', 'Realiza el pedido correctamente.');
            
    } else {
        
        return redirect('/productos')->with('pdtnoelmdo', 'Realiza el pedido correctamente.');
        
        
    }
      
        
    }
    public function eliminarinsu(Request $request)
    {
        $resp=0;
        $id=$request->id;
        $insumoproductos=Insumoproducto::find($id);
        $insumoproductos->delete();
    
        echo $resp;
    }

    public function cambioEstadoProducto (Producto $producto)
    {
        $id=$producto->id;
        $productoVenta=DB::table('detalleventas')->select('id_producto')->where('id_producto', '=', $id)->pluck('id_producto')->first();
         if($producto->estado == 0)  {
            $producto->update(['estado'=>1]);
         }elseif ($producto->estado == 1 && $productoVenta!=$id) {
            $producto->update(['estado'=>0]);
         }else{ return redirect('/productos')->with('pdtnoelmdo', 'Realiza el pedido correctamente.');}
         return redirect()->back();    
    }

    public function nombrerepetido (Request $request)
    {

        $nombre=$request->nombre;
        
        $nombres=DB::table('productos')->select('nombre')->where('nombre', '=', $nombre)->pluck('nombre')->first();
        return $nombres;
        
    }

    public function getInsumoPro (Request $request)
    {
        
        $id=$request->ids;
        $insumoproductos=Insumoproducto::find($id);
        $insumoproductos->delete();
        echo $resp;
    }


    public function getInsumoProList (Request $request)
    {
        
        $id=$request->idA;
        $insumoproductos = Insumoproducto::where('id_producto',$id)->join('insumos', 'insumoproductos.id_insumo', 'insumos.id')->select('insumos.nombre_insumo','insumoproductos.cantidad')->get();
        echo $insumoproductos;
    }


   
}