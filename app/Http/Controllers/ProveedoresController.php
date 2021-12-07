<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedores;
use Illuminate\Database\QueryException; //Importar clase de Queryexception

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores= Proveedores::all();
        return view ('proveedores.index')->with('proveedores',$proveedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ //Validacion que me sea requeridos estos campos//
           'nit' => 'required|unique:proveedores|min:10||max:10|',
           'nombrecontacto'=>'required',
           'correocontacto'=>'required|email',//validacion que me contenga el campo como tipo email es decir que tenga @//
           'numerocontacto'=>'required|min:7||max:10|',
           'empresa'=>'required',
           'direccionempresa'=>'required'
        ]);
        try { $proveedores= new Proveedores();
        $proveedores->nit=$request->get('nit');
        $proveedores->nombrecontacto=$request->get('nombrecontacto');
        $proveedores->correocontacto=$request->get('correocontacto');
        $proveedores->numerocontacto=$request->get('numerocontacto');
        $proveedores->empresa=$request->get('empresa');
        $proveedores->direccionempresa=$request->get('direccionempresa');                                                                                                                                                                                                                                                                                                                               
        $proveedores->save();

        return redirect('/proveedores')->with('guardar','True');


            } catch (QueryException $e) {

        return redirect('/proveedores/create')->with('errorregistro','errorregistro');
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
        $proveedores=Proveedores::find($id);
        return view('proveedores.detail')->with('proveedores',$proveedores); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedores=Proveedores::find($id);
        return view ('proveedores.edit')->with('proveedores',$proveedores);
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
         $request->validate([ //Validacion que me sea requeridos estos campos//
           //'nit' => 'unique:proveedores',//|min:3|max:5//
            'nombrecontacto'=>'required',
            'correocontacto'=>'required|email',//validacion que me contenga el campo como tipo email es decir que tenga @//
            'numerocontacto'=>'required|min:7||max:10|',
             'empresa'=>'required',
             'direccionempresa'=>'required'
          ]); 

          try { $proveedores= Proveedores::find($id);

        // $proveedores->nit=$request->get('nit'); //Se puso en comentario porque no se debe dejar editar
        $proveedores->nombrecontacto=$request->get('nombrecontacto');
        $proveedores->correocontacto=$request->get('correocontacto');
        $proveedores->numerocontacto=$request->get('numerocontacto');
        // $proveedores->empresa=$request->get('empresa'); //Se puso en comentario porque no se debe dejar editar
        $proveedores->direccionempresa=$request->get('direccionempresa');

        $proveedores->save();

        return redirect('/proveedores')->with('edit','True'); 
             } catch (QueryException $e) {
        return redirect()->back()->with('error','True');

                                         }  
               
        }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    public function cambioEstadoProveedor (Proveedores $proveedores)
    {
         if($proveedores->estado == 0)  {
             $proveedores->update(['estado'=>1]);
         }elseif ($proveedores->estado == 1) {
             $proveedores->update(['estado'=>0]);
         }else{}
         return redirect()->back();    
    }

}
