<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $productos = Producto::all();
        return view('productos.index')->with('productos',$productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insumos=Insumo::all();
        $insumoproducto=Insumoproducto::all();
        
        return view ('productos.create', compact('insumos', 'insumoproducto'))
        ->with('insumos', $insumos, 'insumoproducto', $insumoproducto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    

        //$nomInsumo=$request->get('id_insumo');
        //$id_Insumo = VentaController::getIsumo($nomInsumo);
         
        /*try{
            DB::beginTransaction();
            $productos = new Producto();
            $productos->nombre = $nombre;
            $productos->precio = $precio;
   
            
            $productos->saveOrFail();

            $insumoproducto = new InsumoProducto();
            
            $insumoproducto->id_producto = $productos->id;
            $insumoproducto->cantidad = $request->get('cantidad');
            
            
            $insumoproducto->saveOrFail();
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }*/
    


    public function save(Request $request){
        /*if (count($request-> idInsumo) < 1 || count($request-> cantidad) <1) {
            return redirect('/productos');
        }*/


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
            return redirect('/productos')->with('success','Producto creado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/productos')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
        }
    }

        public function getIsumo($nomInsumo)
        {
            $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
            $rs = mysqli_query($db, "SELECT (id) AS id FROM insumos WHERE cedula=$nomInsumo");
            if ($row = mysqli_fetch_row($rs)) {
            $id = trim($row[0]);
            }
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
        //$insumoproductos=Insumoproducto::where('id_producto',$id)->get();
        $insumos=Insumo::all();
        $insumoproductos = Insumoproducto::where('id_producto',$id)->join('insumos', 'insumoproductos.id_insumo', 'insumos.id')->select('insumos.nombre_insumo','insumoproductos.cantidad')->get();
        return view('productos.edit',compact('insumoproductos','insumos'))->with('productos',$productos,'insumos',$insumos,'insumoproductos',$insumoproductos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {$productos= Producto::find($id);
            
        $productos->nombre =$request->get('nombre');
        $productos->precio =$request->get('precio');
        

        foreach ($request->id_insumo as $key => $value) {
            $productos->insumoproducto($id,$value, $request ->cantidad [$key]);
        }

        $productos->save();
        return redirect('/productos');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $productos = Producto::find($id);
        $productos ->delete();
        return redirect('/productos');
    }
    public function insudestroy($id_Insumo,$id_Producto)
    {
        $db = mysqli_connect("localhost", "root", "", "piloncitosoft");
        $rs = mysqli_query($db, "SELECT (idIsumo)  FROM Insumoproducto WHERE idProducto=$id_Producto AND idInsumo=$id_Insumo");
       
        $insumoproductos=Insumoproducto::find($rs);
        $insumoproductos ->delete();
        
    }

    public function  camtado(Request $request) 
    {
     
    $productoUpdate = Producto::findOrFail($request->id)->update(['estado' => $request->estado]); 

    if($request->estado == 1)  {
        $newStatus = '<a>Activo</a>';
    }else{
        $newStatus ='<a>Inactivo</a>';
    }

    return response()->json(['var'=>''.$newStatus.'']);
    }

}
