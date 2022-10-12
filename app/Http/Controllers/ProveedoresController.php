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
           'nombre' => 'required|unique:proveedores',
           'correo'=>'required|email',//validacion que me contenga el campo como tipo email es decir que tenga @//
           'numero'=>'required',
           'especialidad'=>'required',
           'hospital'=>'required',
           'direccionhospital'=>'required'
        ]);
        try { $proveedores= new Proveedores();
        $proveedores->nombre=$request->get('nombre');
        $proveedores->correo=$request->get('correo');
        $proveedores->numero=$request->get('numero');
        $proveedores->especialidad=$request->get('especialidad');
        $proveedores->hospital=$request->get('hospital');
        $proveedores->direccionhospital=$request->get('direccionhospital');                                                                                                                                                                                                                                                                                                                               
        $proveedores->save();

        return redirect('/proveedores')->with('success', 'Se guardo el medico correctamente✅');

} catch (QueryException $e) {
echo '<script language="javascript">alert("ERROR❌❗:El NIT o CEDULA ya existe, Agregue de nuevo el medico por favor.");window.location.href="/proveedores/create"</script>';
return redirect('/proveedores')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
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
            'nombre'=>'required',
            'correo'=>'required|email',//validacion que me contenga el campo como tipo email es decir que tenga @//
            'numero'=>'required',
        //     'empresa'=>'required', //Se puso en comentario porque no es requerido
             'direccionhospital'=>'required'
          ]); 

          try { $proveedores= Proveedores::find($id);

        // $proveedores->nit=$request->get('nit'); //Se puso en comentario porque no se debe dejar editar
        $proveedores->nombre=$request->get('nombre');
        $proveedores->correo=$request->get('correo');
        $proveedores->numero=$request->get('numero');
        // $proveedores->empresa=$request->get('empresa'); //Se puso en comentario porque no se debe dejar editar
        $proveedores->direccionhospital=$request->get('direccionhospital');

        $proveedores->save();

        return redirect('/proveedores')->with('success', 'Se modifico el medico correctamente✅');
             } catch (QueryException $e) {
        // echo '<script language="javascript">alert("ERROR❌❗:El NIT o CEDULA ya existe, Agregue de nuevo el proveedor por favor.");window.location.href="/proveedores/create"</script>';
        return redirect('/proveedores')->withErrors('Ocurrio un error inesperado, vuelva a intentarlo');
                                         }  
               
        }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $proveedores= Proveedores::find($id);
    //     $proveedores->delete();
    //     return redirect('/proveedores');
    // }

    

}
