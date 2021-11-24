<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Insumo;
use App\Models\Compra;


class InsumoController extends Controller
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
    {   /* 
        $insumos =Insumo::where('estado', '!=',0)->get();
        $insumos =Insumo::all();}
        */

        $insumos =Insumo::orderBy('estado', 'DESC')->get();
        return view('insumo.index')->with ('insumos',$insumos);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('insumo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
      
        
   try {
            $insumos= new Insumo();
            $insumos->nombre_insumo=$request->get('nombre_insumo');
            $insumos->cantidad=$request->get('cantidad');
            $insumos->save();
            return redirect('insumos')->with('guardar','True');

        } catch (QueryException $e) {

         return redirect('insumos/create')->with('error','True');



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

        $insumo =Insumo::find($id);
        return view('insumo.show')->with('insumo',$insumo);
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $insumo =Insumo::find($id);
        return view('insumo.edit')->with('insumo',$insumo);
       

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
        try {

        $insumo= Insumo::find($id);
        $insumo->nombre_insumo=$request->get('nombre_insumo');
        $insumo->save();
        return redirect('insumos')->with('edit','True');  
         }catch (QueryException $e) {
        
        return redirect()->back()->with('error','True');


    }  

      }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insumo = Insumo::find($id);
        if ($insumo->estado == 1) {
            return redirect('insumos')->with('error', 'True');    
        }else {
    
            $insumo->delete();
            return redirect('insumos')->with('cancelar', 'True');
        }
    

    }




    public function cambioEstadoInsumo (Insumo $insumo)
    {
         if($insumo->estado == 0)  {
             $insumo->update(['estado'=>1]);
         }elseif ($insumo->estado == 1) {
             $insumo->update(['estado'=>0]);
         }else{}
         return redirect()->back();    
    }


}