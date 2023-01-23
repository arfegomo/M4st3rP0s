<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Rol;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-permiso|crear-permiso|editar-permiso|borrar-permiso',['only'=>['index']]);
        $this->middleware('permission:crear-permiso',['only'=>['create','store']]);
        $this->middleware('permission:editar-permiso',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-permiso',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('permisos.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('permisos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
        'name' => 'required|unique:permissions|max:255',
        'guard_name' => 'required|max:255',
        
    ]);

        $permission = Permission::create([
                'name' => $request->get('name'),
                'guard_name' => $request->get('guard_name')
            ]);
                  
        return redirect()->route('permisos.edit',array('permiso'=>$permission->id))->with('message', 'Registro creado correctamente!!!');
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
        $permission = Permission::find($id);
        

        return view('permisos.editar', compact('permission'));
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
        $this->validate($request,[
        'name' => 'required|max:255',
        
    ]);


         $permission = Permission::find($id);  
         $permission->name = $request->get('name');

         
         $permission->save();
         
         
        return redirect()->route('permisos.edit',array('permiso'=>$id))->with('message', 'Registro actualizado correctamente!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permisos = Permission::find($id);
        $permisos->delete();
        
        return redirect()->route('permisos.index');
    }
}
