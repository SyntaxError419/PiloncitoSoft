<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index')->with('clientes',$clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
        
            
        
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
            DB::beginTransaction();
            $clientes = new Cliente();
        
        $clientes->nombre = $request->get('nombre');
        $clientes->cedula = $request->get('cedula');
        $clientes->direccion = $request->get('direccion');
        $clientes->contacto = $request->get('contacto');

        $clientes->saveOrFail();
        
        DB::commit();

        return redirect('/clientes');
        } catch (QueryException $e) {
            DB::rollBack();
            echo '<script language="javascript">alert("Cedula ya registrada, por favor verifica");window.location.href="/clientes/create"</script>';
            

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
        $cliente = cliente::find($id) ;
        return view('clientes.edit')->with('cliente',$cliente);
        
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
        $cliente = Cliente::find($id);
        
        $cliente->nombre = $request->get('nombre');
        $cliente->cedula = $request->get('cedula');
        $cliente->direccion = $request->get('direccion');
        $cliente->contacto = $request->get('contacto');

        $cliente->save();

        return redirect('/clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente ->delete();
        return redirect('/clientes');
    }

    public function  camStado(Request $request) 
    {
     
    $clienteUpdate = Cliente::findOrFail($request->id)->update(['estado' => $request->estado]); 

    if($request->estado == 1)  {
        $newStatus = '<a>Activo</a>';
    }else{
        $newStatus ='<a>Inactivo</a>';
    }

    return response()->json(['var'=>''.$newStatus.'']);
    }



}
