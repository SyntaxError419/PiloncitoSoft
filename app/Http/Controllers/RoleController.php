<?php

namespace App\Http\Controllers;

use Flash;
use App\Models\menu;
use App\Models\Role;
use App\Models\rolemenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'ASC')
        ->paginate(10);
         $menus=rolemenu::join('roles','rolemenu.id_rol','=','roles.id')
         ->join('menus','rolemenu.id_menu','=','menus.id')
         ->select('menus.nombre','rolemenu.id_rol')
         ->get();


        return view('roles.index', compact('roles','menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $menus=menu::all();
        return view('roles.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nombre'=>'required',

        ]);

        $rol=Role::create(['nombre'=> $request -> nombre]);
        $menu=menu::all();
        foreach($request->menu as $menu ){
            rolemenu::create(['id_rol'=>$rol->id,'id_menu'=>$menu]);
        }


        return redirect(route('roles.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role -> all();
    return view('roles.show',compact('role'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $roles = Role::find($id);
        $menus =  menu::all();
        return view('roles.edit', compact('roles','menus'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        $roles = Role::find($id);
        $roles -> update([
            'nombre'=>$request->nombre,
            'estado'=>$request->estado,
        ]);
        $rolemenu=rolemenu::select('*')->where('id_rol','=',$roles->id) ->get();
        try{
        DB::beginTransaction();
        foreach($rolemenu as $rolemenu){
            $rolemenu->delete();
        }
        foreach($request->menu as $menu ){
            rolemenu::create(['id_rol'=>$roles->id,'id_menu'=>$menu]);
        }
        DB::commit();
        return redirect()->route('roles.index');
        }
        catch(exeption $e){

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();

        return redirect()->route('roles.index');
    }
}
