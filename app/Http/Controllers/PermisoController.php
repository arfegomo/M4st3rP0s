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
        $permisos = Permission::paginate(10);
        return view('permisos.index',compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $role = Role::get();
        return view('permisos.crear',compact('role'));
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
        
        $permission->syncRoles($request->get('role'));
                  
        return redirect()->route('permisos.index')->with('success', 'Registro creado correctamente.');
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
        $permiso = Permission::find($id);
        $role = Role::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.permission_id',$id)
            ->pluck('role_has_permissions.role_id','role_has_permissions.role_id')
            ->all();
        

        return view('permisos.editar', compact('permiso','role','rolePermissions'));
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
         $permission->syncRoles($request->get('role'));
         
         
        return redirect()->route('permisos.index')->with('success', 'Registro actualizado correctamente.');
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
        
        return redirect()->route('permisos.index')->with('success', 'Registro eliminado correctamente.');
    }
}
