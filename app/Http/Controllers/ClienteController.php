<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('estado', 'DESC')->get();
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
        $request->validate([ //Validacion que me sea requeridos estos campos//
            'nombre' => 'required',
            'numerodocumento'=>'required |unique:clientes',
            'apellidos'=>'required',
            'genero'=>'required',
            'edad'=>'required',
            'tipodocumento'=>'required'
            
         ]);

        try {
            DB::beginTransaction();
            $clientes = new Cliente();
        
        $clientes->nombre = $request->get('nombre');
        $clientes->apellidos = $request->get('apellidos');
        $clientes->tipodocumento = $request->get('tipodocumento');
        $clientes->numerodocumento = $request->get('numerodocumento');
        $clientes->genero = $request->get('genero');
        $clientes->edad = $request->get('edad');
        $clientes->correo = $request->get('correo');
        $clientes->parentesco = $request->get('parentesco');

        $clientes->saveOrFail();
        
        DB::commit();

        return redirect('/clientes');
        } catch (QueryException $e) {
            DB::rollBack();
            echo '<script language="javascript">alert("Documento ya registrado, por favor verifica");window.location.href="/clientes/create"</script>';
            

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
        $cliente = cliente::find($id) ;
        return view('clientes.show')->with('cliente',$cliente);
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
        $request->validate([ //Validacion que me sea requeridos estos campos//
            'nombre' => 'required',
            'cedula'=>'required ',
            'direccion'=>'required',
            'contacto'=>'required'
            
         ]);
         try {
        $cliente = Cliente::find($id);
        
        $cliente->nombre = $request->get('nombre');
        $cliente->cedula = $request->get('cedula');
        $cliente->direccion = $request->get('direccion');
        $cliente->contacto = $request->get('contacto');

        $cliente->save();

        return redirect('/clientes');
    } catch (QueryException $e) {
        DB::rollBack();
        echo '<script language="javascript">alert("Cedula ya registrada, por favor verifica");window.location.href="/clientes/create"</script>';
        

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
        $cliente = Cliente::find($id);
        $cliente ->delete();
        return redirect('/clientes');
    }

    

    


    public function cambioEstadoCliente (Cliente $cliente)
    {
         if($cliente->estado == 0)  {
            $cliente->update(['estado'=>1]);
         }elseif ($cliente->estado == 1) {
            $cliente->update(['estado'=>0]);
         }else{}
         return redirect()->back();    
    }


}
